<?php

namespace App\Http\Controllers\Points;

use App\Http\Controllers\Controller;
use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin')->except(['index']);
    }

    public function index()
    {
        $points = Point::pointsByCity();

        return view('point.main', ['points' => $points]);
    }

    public function point($id)
    {
        $points = Point::pointsByCity();
        $point = Point::with(['contract'])->find($id);

        return view('point.point', ['points' => $points, 'point' => $point]);
    }

    public function importXlsView()
    {
        return view('importxls.import');
    }

    public function saveXLS()
    {
        //
    }
}
