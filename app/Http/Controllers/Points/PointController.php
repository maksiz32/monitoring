<?php

namespace App\Http\Controllers\Points;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Point;
use App\Models\RemoteControl;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $point = Point::with(['contract', 'remotes'])->find($id);

        return view('point.point', ['points' => $points, 'point' => $point]);
    }

    public function importXlsView()
    {
        return view('importxls.import');
    }

    public function saveXLS(Request $request)
    {
        $file = $request->file('xlsFile');
        $fileExtension = $file->clientExtension();
        $allowedExtensions = ['xls', 'xlsx'];

        if (!in_array($fileExtension, $allowedExtensions)) {
            return redirect()->route('view-import-xls')
                ->with(['message' => __('messages.xls.store.fail')]);
        }

        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->setActiveSheetIndex(0);

        $maxCol = $worksheet->getHighestDataColumn();
        $maxRow = $worksheet->getHighestDataRow();
        $rows = $worksheet->rangeToArray("A1:$maxCol$maxRow", null, false, true, true);
        array_shift($rows);

        if (count($rows) > 0) {
            Point::truncate();
            Contract::truncate();
            RemoteControl::truncate();

            foreach ($rows as $row) {
                array_pop($row);
                $points['city'] = $row['A'];
                $points['address'] = $row['B'];
                $points['is_active'] = !empty($row['C']);
                $points['router'] = $row['D'];
                $points['lan_ip'] = $row['E'];
                $points['vpn_ip'] = $row['F'];
                $points['wan_ip'] = $row['G'];
                $points['telephony_status'] = !empty($row['H']);
                $points['provider'] = $row['I'];
                $points['login'] = $row['J'];
                $points['password'] = $row['K'];
                $points['ups'] = $row['S'];

                $point = Point::create($points);

                if (!empty($row['Q'])) {
                    $contracts['number'] = $row['Q'];
                    $contracts['contracts_master'] = !empty($row['L']) ? $row['L'] : '';
                    $contracts['speed'] = !empty($row['M']) ? $row['M'] : '';
                    $contracts['price'] = !empty($row['N']) ? $row['N'] : '';
                    $contracts['login_pppoe'] = !empty($row['O']) ? $row['O'] : '';
                    $contracts['password_pppoe'] = !empty($row['P']) ? $row['P'] : '';
                    $contracts['point_id'] = $point->id;

                    $contract = Contract::create($contracts);
                }

                if (isset($row['T'])) {
                    $remotes['number'] = $row['T'];
                    $remotes['point_id'] = $point->id;

                    $remote = RemoteControl::create($remotes);
                }

                if (isset($row['U'])) {
                    $remotes['number'] = $row['U'];
                    $remotes['point_id'] = $point->id;

                    $remote = RemoteControl::create($remotes);
                }
            }
        }

        return redirect()->route('point.point')->with(['message' => __('messages.xls.store.success')]);
    }
}
