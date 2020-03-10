<?php namespace App\Http\Controllers;

use App\Http\Requests\TemplateFormRequest;
use App\Invoicer\Repositories\Contracts\TemplateInterface as Template;
use Laracasts\Flash\Flash;

class TemplatesController extends Controller {
    private $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
        $this->middleware('permission:edit_setting');
    }

	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index()
	{
        $template = $this->template->getTemplate('invoice');
        $select = 'invoice';
		return view('settings.template', compact('template', 'select'));
	}

    /**
     * Store a newly created resource in storage.
     * @param TemplateFormRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TemplateFormRequest $request)
	{
		$data = array('name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
        );

        if($this->template->create($data))
            Flash::success(trans('application.record_updated'));
        else
            Flash::error(trans('application.update_failed'));

        return redirect('settings/templates/'.$request->name);
	}

	/**
	 * Display the specified resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $template = $this->template->getTemplate($id);
        $select = $id;
        return view('settings.template', compact('template', 'select'));
	}

    /**
     * Update the specified resource in storage.
     * @param TemplateFormRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(TemplateFormRequest $request, $id)
	{
        $data = array(
            'subject' => $request->subject,
            'body' => $request->body,
        );

        if($this->template->updateById($id, $data))
            Flash::success(trans('application.record_updated'));
        else
            Flash::error(trans('application.update_failed'));

        return redirect('settings/templates/'.$request->name);
	}


}
