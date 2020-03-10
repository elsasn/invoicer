<?php

namespace App\Http\Controllers;

use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\InvoiceItemInterface as InvoiceItem;
use App\Invoicer\Repositories\Contracts\SettingInterface as Setting;
use App\Invoicer\Repositories\Contracts\NumberSettingInterface as Number;
use App\Invoicer\Repositories\Contracts\InvoiceSettingInterface as InvoiceSetting;
use App\Invoicer\Repositories\Contracts\TemplateInterface as Template;
use App\Invoicer\Repositories\Contracts\EmailSettingInterface as MailSetting;
use App\Invoicer\Repositories\Contracts\SubscriptionInterface as Subscription;

class RecurringInvoicesController extends Controller
{
    protected $client,$invoice,$items,$setting,$number,$invoiceSetting, $template, $mail_setting,$subscription;
    public function __construct(Invoice $invoice, Client $client, InvoiceItem $items, Setting $setting, Number $number, InvoiceSetting $invoiceSetting, Template $template, MailSetting $mail_setting, Subscription $subscription){
        $this->invoice   = $invoice;
        $this->client    = $client;
        $this->items     = $items;
        $this->setting   = $setting;
        $this->number    = $number;
        $this->invoiceSetting = $invoiceSetting;
        $this->template  = $template;
        $this->mail_setting = $mail_setting;
        $this->subscription = $subscription;
    }
    public function index()
    {
        $today = date('Y-m-d');
        $model = $this->subscription->model();
        $due_invoices = $model::with('invoice')->where('nextduedate',$today)->where('status',1)->get();
        foreach($due_invoices as $recurring_record){
            $settings     = $this->invoiceSetting->first();
            $start        = $settings ? $settings->start_number : 0;
            $invoice_num  = $this->number->prefix('invoice_number', $this->invoice->generateInvoiceNum($start));
            $due_date = $today;
            $invoiceData = array(
                'client_id'     => $recurring_record->invoice->client_id,
                'number'        => $invoice_num,
                'invoice_date'  => $today,
                'due_date'      => $settings ? date('Y-m-d',strtotime("+".$settings->due_days." days")) : $due_date,
                'notes'         => $recurring_record->invoice->notes,
                'terms'         => $recurring_record->invoice->terms,
                'currency'      => $recurring_record->invoice->currency,
                'status'        => 0,
                'discount'      => $recurring_record->invoice->discount,
                'discount_mode' => $recurring_record->invoice->discount_mode
            );
            $invoice = $this->invoice->create($invoiceData);
            if($invoice) {
                $items = $recurring_record->invoice->items;
                foreach ($items as $item) {
                    $itemsData = array(
                        'invoice_id' => $invoice->uuid,
                        'item_name' => $item->item_name,
                        'item_description' => $item->item_description,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'tax_id' => $item->tax != '' ? $item->tax : null,
                    );
                     $this->items->create($itemsData);
                }
                $cycle = $recurring_record->billingcycle;
            //dd($cycle);
                switch ($cycle) {
                    case 1:
                        $next_due_date = date("Y-m-d", strtotime("+1 month", strtotime($today)));
                        break;
                    case 2:
                        $next_due_date = date("Y-m-d", strtotime("+3 month", strtotime($today)));
                        break;
                    case 3:
                        $next_due_date = date("Y-m-d", strtotime("+6 month", strtotime($today)));
                        break;
                    case 4:
                        $next_due_date = date("Y-m-d", strtotime("+12 month", strtotime($today)));
                        break;
                    default:
                        $next_due_date = date("Y-m-d", strtotime("+12 month", strtotime($today)));
                }
                $subscriptionData = array(
                    'nextduedate' => $next_due_date,
                );
                //dd($subscriptionData);
                $this->subscription->updateById($recurring_record->uuid,$subscriptionData);
                $this->send($invoice->uuid);
            }
        }
    }
    public function send($uuid){
        $invoice = $this->invoice->with('items', 'client')->getById($uuid);
        $mail_setting = $this->mail_setting->first();
        if ($invoice) {
            $settings = $this->setting->first();
            $invoiceSettings = $this->invoiceSetting->first();
            $invoice->totals = $this->invoice->invoiceTotals($uuid);
            $pdf = \PDF::loadView('invoices.pdf', compact('settings', 'invoice', 'invoiceSettings'));

            $data['emailBody'] = trans('application.invoice_generated');
            $data['emailTitle'] = trans('application.invoice_generated');
            $template = $this->template->where('name', 'invoice')->first();
            if ($template) {
                $data_object = new \stdClass();
                $data_object->invoice = $invoice;
                $data_object->settings = $settings;
                $data_object->client = $invoice->client;

                $data['emailBody'] = parse_template($data_object, $template->body);
                $data['emailTitle'] = $template->subject;
            }
            $data['logo'] = $settings ? $settings->logo : '';

            if ($mail_setting) {
                if($mail_setting->protocol == 'smtp'){
                    Config::set('mail.host', $mail_setting->smtp_host);
                    Config::set('mail.username', $mail_setting->smtp_username);
                    Config::set('mail.password', $mail_setting->smtp_password);
                    Config::set('mail.port', $mail_setting->smtp_port);
                }
                try {
                    \Mail::send(['html' => 'emails.layout'], $data, function ($message) use ($pdf, $invoice, $settings,$mail_setting) {
                        $message->from($mail_setting->from_email, $settings ? $settings->from_name : '');
                        $message->sender($mail_setting->from_email, $settings ? $settings->from_name : '');
                        $message->to($invoice->client->email, $invoice->client->name);
                        $message->subject(trans('application.invoice_generated'));
                        $message->attachData($pdf->output(), 'invoice_' . $invoice->number . '_' . date('Y-m-d') . '.pdf');
                    });
                    echo trans('application.email_sent');
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                echo trans('application.email_settings_error');
            }
        }
    }
}
