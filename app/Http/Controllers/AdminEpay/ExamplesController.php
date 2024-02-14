<?php

namespace App\Http\Controllers\AdminEpay;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AdminEpay\ExampleCreateRequest;
use App\Http\Requests\AdminEpay\ExampleUpdateRequest;
use App\Services\AdminEpay\ExampleService;

/**
 * Class ExamplesController.
 *
 * @package namespace App\Http\Controllers\AdminEpay;
 */
class ExamplesController extends Controller
{
    protected ExampleService $exampleService;

    /**
     * constructor
     *
     * @param ExampleService $exampleService
     */
    public function __construct(ExampleService $exampleService)
    {
        $this->exampleService = $exampleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $filter = (object)[
            'name' => $request->name ?? '',
            'start_at' => $request->start_at ?? '',
            'end_at' => $request->end_at ?? '',
            'page' => $request->page ?? 1,
            'per_page' => $request->per_page ?? config('const.LIMIT_PAGINATION')
        ];
        $examples = $this->exampleService->getList($filter)->paginate($filter->per_page);

        return $examples;

    }


    //  --------- Below is code generated automatically by L5 (resource), can refer more  ---------

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  ExampleCreateRequest $request
    //  *
    //  * @return \Illuminate\Http\Response
    //  *
    //  * @throws \Prettus\Validator\Exceptions\ValidatorException
    //  */
    // public function store(ExampleCreateRequest $request)
    // {
    //     try {
    //
    //         $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
    //
    //         $example = $this->repository->create($request->all());
    //
    //         $response = [
    //             'message' => 'Example created.',
    //             'data'    => $example->toArray(),
    //         ];
    //
    //         if ($request->wantsJson()) {
    //
    //             return response()->json($response);
    //         }
    //
    //         return redirect()->back()->with('message', $response['message']);
    //     } catch (ValidatorException $e) {
    //         if ($request->wantsJson()) {
    //             return response()->json([
    //                 'error'   => true,
    //                 'message' => $e->getMessageBag()
    //             ]);
    //         }
    //
    //         return redirect()->back()->withErrors($e->getMessageBag())->withInput();
    //     }
    // }
    //
    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int $id
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $example = $this->repository->find($id);
    //
    //     if (request()->wantsJson()) {
    //
    //         return response()->json([
    //             'data' => $example,
    //         ]);
    //     }
    //
    //     return view('examples.show', compact('example'));
    // }
    //
    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int $id
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $example = $this->repository->find($id);
    //
    //     return view('examples.edit', compact('example'));
    // }
    //
    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  ExampleUpdateRequest $request
    //  * @param  string            $id
    //  *
    //  * @return Response
    //  *
    //  * @throws \Prettus\Validator\Exceptions\ValidatorException
    //  */
    // public function update(ExampleUpdateRequest $request, $id)
    // {
    //     try {
    //
    //         $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
    //
    //         $example = $this->repository->update($request->all(), $id);
    //
    //         $response = [
    //             'message' => 'Example updated.',
    //             'data'    => $example->toArray(),
    //         ];
    //
    //         if ($request->wantsJson()) {
    //
    //             return response()->json($response);
    //         }
    //
    //         return redirect()->back()->with('message', $response['message']);
    //     } catch (ValidatorException $e) {
    //
    //         if ($request->wantsJson()) {
    //
    //             return response()->json([
    //                 'error'   => true,
    //                 'message' => $e->getMessageBag()
    //             ]);
    //         }
    //
    //         return redirect()->back()->withErrors($e->getMessageBag())->withInput();
    //     }
    // }
    //
    //
    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int $id
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $deleted = $this->repository->delete($id);
    //
    //     if (request()->wantsJson()) {
    //
    //         return response()->json([
    //             'message' => 'Example deleted.',
    //             'deleted' => $deleted,
    //         ]);
    //     }
    //
    //     return redirect()->back()->with('message', 'Example deleted.');
    // }
}
