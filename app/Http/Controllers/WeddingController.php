<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateWeddingRequest;
use App\Http\Requests\UpdateWeddingRequest;
use App\Models\Wedding;
use App\Repositories\WeddingRepository;
use App\Utility\Files;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class WeddingController extends AppBaseController
{
    /** @var WeddingRepository */
    private $weddingRepository;


	/**
	 * @param WeddingRepository $weddingRepository
	 */
    public function __construct(WeddingRepository $weddingRepository) {
		parent::__construct();
        $this->weddingRepository = $weddingRepository;
		$this->activeMenu = ['active' => 'wedding', 'subMenu' => ''];
		$this->viewPath = 'weddings.';
		$this->routePath = 'weddings.';
    }

    /**
     * Display a listing of the Wedding.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->weddingRepository->pushCriteria(new RequestCriteria($request));
        $weddings = $this->weddingRepository->all();

		return $this->assignToView('Wedding List', 'index', [
			'weddings' => $weddings
		]);
    }

    /**
     * Show the form for creating a new Wedding.
     *
     * @return Response
     */
    public function create()
    {
		return $this->assignToView('New Wedding', 'create');
    }

    /**
     * Store a newly created Wedding in storage.
     *
     * @param CreateWeddingRequest $request
     *
     * @return Response
     */
    public function store(CreateWeddingRequest $request)
    {
        $input = $request->all();
		$imagePrefix = Wedding::getPrefixImage();
		$imageBasePath = Wedding::getBaseImagePath();
		$input['groom_image'] = Files::saveUploadImage('groom_image', $imagePrefix, $imageBasePath);
		$input['bride_image'] = Files::saveUploadImage('bride_image', $imagePrefix, $imageBasePath);

        $wedding = $this->weddingRepository->create($input);
        Flash::success('Wedding saved successfully.');

        return redirect(route('weddings.index'));
    }

    /**
     * Show the form for editing the specified Wedding.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $wedding = $this->weddingRepository->findWithoutFail($id);
        if (empty($wedding)) {
            Flash::error('Wedding not found');
            return redirect(route('weddings.index'));
        }
		return $this->assignToView('Edit Wedding', 'edit', [
			'wedding' => $wedding
		]);
    }

    /**
     * Update the specified Wedding in storage.
     *
     * @param string $id
     * @param UpdateWeddingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWeddingRequest $request)
    {
        $wedding = $this->weddingRepository->findWithoutFail($id);
        if (empty($wedding)) {
            Flash::error('Wedding not found');
            return redirect(route('weddings.index'));
        }

		$input = $request->all();
		$imagePrefix = Wedding::getPrefixImage();
		$imageBasePath = Wedding::getBaseImagePath();
		$input['groom_image'] = Files::saveEditUploadImage($input, $wedding->groom_image, 'groom_image', $imagePrefix, $imageBasePath, 'imageIsDelete');
		$input['bride_image'] = Files::saveEditUploadImage($input, $wedding->bride_image, 'bride_image', $imagePrefix, $imageBasePath, 'welcomeImageIsDelete');

		/**
		 * Clean update the uploaded image
		 */
		if (intval($input['groomImageIsDelete']) == 1) {
			Files::delete($wedding->groom_image);
		} else {
			if ($input['groom_image'] !== $wedding->groom_image) {
				Files::delete($wedding->groom_image);
			}
		}

		if (intval($input['brideImageIsDelete']) == 1) {
			Files::delete($wedding->groom_image);
		} else {
			if ($input['bride_image'] !== $wedding->bride_image) {
				Files::delete($wedding->bride_image);
			}
		}

		$wedding = $this->weddingRepository->update($input, $id);
        Flash::success('Wedding updated successfully.');

        return redirect(route('weddings.index'));
    }

    /**
     * Remove the specified Wedding from storage.
     *
     * @param string $id
     *
     * @return Response
     */
    public function destroy($id)
    {
		$wedding = $this->weddingRepository->findWithoutFail($id);
        if (empty($wedding)) {
            Flash::error('Wedding not found');
            return redirect(route('weddings.index'));
        }

        $this->weddingRepository->delete($id);
		Files::delete($wedding->groom_image);
		Files::delete($wedding->bride_image);

        Flash::success('Wedding deleted successfully.');
        return redirect(route('weddings.index'));
    }
}
