<?php

namespace App\Http\Controllers\Points;

use App\Http\Controllers\Controller;
use App\Http\Requests\PointRequest;
use App\Models\Contract;
use App\Models\Point;
use App\Models\RemoteControl;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PointController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin')->except(['index', 'point']);
    }

    public function index()
    {
        $points = Point::pointsByCity();

        return view('point.main', ['points' => $points]);
    }

    public function point(Point $point, $city)
    {
        $points = Point::pointsByCity();
        $point = Point::findOrFail($point->id);

        return view('point.point', ['points' => $points, 'point' => $point, 'city' => (int)$city]);
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
                ->with('message', __('messages.xls.store.fail'));
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
                // Точки
                $points['city'] = $row['A'];
                $points['address'] = $row['B'];
                $points['is_active'] = (empty($row['C']));
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
                    // Договоры
                    $contracts['number'] = $row['Q'];
                    $contracts['contracts_master'] = !empty($row['L']) ? $row['L'] : '';
                    $contracts['speed'] = !empty($row['M']) ? $row['M'] : '';
                    $contracts['price'] = !empty($row['N']) ? $row['N'] : '';
                    $contracts['login_pppoe'] = !empty($row['O']) ? $row['O'] : '';
                    $contracts['password_pppoe'] = !empty($row['P']) ? $row['P'] : '';
                    $contracts['point_id'] = $point->id;

                    Contract::create($contracts);
                }

                if (isset($row['T'])) {
                    // Удалённое управление
                    $remotes['number'] = $row['T'];
                    $remotes['point_id'] = $point->id;

                    RemoteControl::create($remotes);
                }

                if (isset($row['U'])) {
                    // Удалённое управление
                    $remotes['number'] = $row['U'];
                    $remotes['point_id'] = $point->id;

                    RemoteControl::create($remotes);
                }
            }
        }

        return redirect()->route('point.point')->with('message', __('messages.xls.store.success'));
    }

    public function new()
    {
        return view('point.new');
    }

    public function store(PointRequest $request)
    {
        $point = new Point();
        $point = $point->fill($request->validated());
        $point->is_active = (int)$request->is_active === 1;
        $point->telephony_status = (int)$request->telephony_status === 1;

        if ($point->save()) {
            return redirect(route('point.onepoint', ['point' => $point, 'city' => $point->city]))
                ->with('message', __('messages.point.input.success'));
        }

        return back()->with('errors', __('messages.point.input.fail'));
    }

    public function edit(Point $point)
    {
        return view('point.edit', ['point' => Point::findOrFail($point->id)]);
    }

    public function update(PointRequest $request, Point $point)
    {
        $point = $point->fill($request->validated());
        $point->is_active = $point->is_active === 1;
        $point->telephony_status = $point->telephony_status === 1;

        if ($point->save()) {
            return redirect(route('point.onepoint', ['point' => $point, 'city' => $point->city]))
                ->with('message', __('messages.point.edit.success'));
        }

        return back()->with('errors', __('messages.point.edit.fail'));
    }

    public function close(Point $point)
    {
        // Сделать is_active = false
        $point->is_active = false;

        if ($point->save()) {
            return redirect(route('point.onepoint', ['point' => $point, 'city' => $point->city]))
                ->with('message', __('messages.point.close.success'));
        }

        return back()->with('errors', __('messages.point.close.fail'));
    }

    public function ping($ip)
    {
        exec("ping -c 4 www.google.ru",$output, $status);
// под *nix заменить -n 1 на -c 1
        if ($status <> 0) {
//echo "Offline";
        }
sleep(10);
        return response()->json(['message' => __($output)]);
    }
}
