<?php

namespace App\Http\Controllers\Points;

use App\Http\Controllers\Controller;
use App\Http\Requests\PointRequest;
use App\Models\Contract;
use App\Models\Point;
use App\Models\RemoteControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $point = Point::with(['printers', 'devices', 'remotes'])->findOrFail($point->id);

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

    /**
     * Общая выгрузка
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function exportXls1()
    {
        $defaultStyleArray = array(
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Calibri'
            )
        );

        $staticTitle = [
            '№ п/п',
            'Город',
            'Адрес',
            'Статус точки',
            'Роутер',
            'LAN IP',
            'VPN',
            'WAN IP',
            'Статус телефонии',
            'Провайдер',
            'Логин',
            'Пароль',
            'ИБП',
        ];

        $contractTitle = [
            'Номер договора',
            'Владелец',
            'Скорость',
            'Стоимость',
            'Логин PPPoE',
            'Пароль PPPoE',
        ];

        $printerTitle = [
            'Принтер',
            'S/N',
            'Описание',
            'Запасной картридж',
        ];

        $remoteTitle = [
            'Номер подключения',
            'Описание/пароль',
        ];

        $deviceTitle = [
            'Устройство',
            'S/N',
            'Разное',
        ];

        $tableHeadStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '000000'
                    ]
                ],
            ],
        ];

        $tableBodyStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '000000'
                    ]
                ],
            ],
        ];

        $tableBodyStyleNotActive = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '000000'
                    ]
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => [
                    'argb' => 'FFA0A0A0',
                ],
            ],
        ];

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator('Мир упаковки')
            ->setLastModifiedBy('Мир упаковки')
            ->setTitle('Мир упаковки - Точки')
            ->setSubject('Мир упаковки - Точки')
            ->setDescription('Мир упаковки - Точки');

        $currentRow = 1;

        $points = Point::with(['printers', 'devices', 'remotes', 'contract'])->get();

        // Получить максимальные значения связанных данных
        $maxPrintersCount = 0;
        $maxDevicesCount = 0;
        $maxRemotesCount = 0;
        foreach ($points as $point) {
            $countPrinters = $point->printers->count();
            $maxPrintersCount = ($maxPrintersCount < $countPrinters) ? $countPrinters : $maxPrintersCount;

            $countDevices = $point->devices->count();
            $maxDevicesCount = ($maxDevicesCount < $countDevices) ? $countDevices : $maxDevicesCount;

            $countRemotes = $point->remotes->count();
            $maxRemotesCount = ($maxRemotesCount < $countRemotes) ? $countRemotes : $maxRemotesCount;
        }

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getDefaultColumnDimension()->setWidth(18);

        $spreadsheet->getDefaultStyle()
            ->applyFromArray($defaultStyleArray);
        $spreadsheet->getDefaultStyle()->getAlignment()->setWrapText(true);;

        $maxColumn = 1;
        // Шапка для точки
        foreach ($staticTitle as $title) {
            $sheet->setCellValueByColumnAndRow($maxColumn, $currentRow, $title);
            $maxColumn++;
        }

        // Шапка для договора
        foreach ($contractTitle as $title) {
            $sheet->setCellValueByColumnAndRow($maxColumn, $currentRow, $title);
            $maxColumn++;
        }

        // Шапка для удалёнок
        if ($maxRemotesCount > 0) {
            for ($i = 0; $i < $maxRemotesCount; $i++) {
                foreach ($remoteTitle as $title) {
                    $sheet->setCellValueByColumnAndRow($maxColumn, $currentRow, $title);
                    $maxColumn++;
                }
            }
        }

        // Шапка для принтеров
        if ($maxPrintersCount > 0) {
            for ($i = 0; $i < $maxPrintersCount; $i++) {
                foreach ($printerTitle as $title) {
                    $sheet->setCellValueByColumnAndRow($maxColumn, $currentRow, $title);
                    $maxColumn++;
                }
            }
        }

        // Шапка для устройств
        if ($maxDevicesCount > 0) {
            for ($i = 0; $i < $maxDevicesCount; $i++) {
                foreach ($deviceTitle as $title) {
                    $sheet->setCellValueByColumnAndRow($maxColumn, $currentRow, $title);
                    $maxColumn++;
                }
            }
        }

        $maxColumn--;
        $sheet->getStyleByColumnAndRow(1, $currentRow, $maxColumn, $currentRow)
            ->applyFromArray($tableHeadStyle);

        $currentRow++;

        foreach ($points as $index => $point) {
            // Точки продаж
            $columnIndex = 1;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $index + 1);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->city);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->address);
            $columnIndex++;
            $pointStatus = ($point->is_active) ? '' : 'Закрыта';
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $pointStatus);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->router);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->lan_ip);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->vpn_ip);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->wan_ip);
            $columnIndex++;
            $phonesStatus = ($point->telephony_status) ? 'Готово' : '';
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $phonesStatus);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->provider);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->login);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->password);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->ups);
            $columnIndex++;

            // Договор
            if ($point->contract) {
                $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, "№ " . $point->contract->number);
                $columnIndex++;
                $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->contract->contracts_master);
                $columnIndex++;
                $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->contract->speed);
                $columnIndex++;
                $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->contract->price);
                $columnIndex++;
                $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->contract->login_pppoe);
                $columnIndex++;
                $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->contract->password_pppoe);
                $columnIndex++;
            } else {
                $columnIndex += 6;
            }

            // Удалёнки
            if ($maxRemotesCount > 0) {
                for ($i = 0; $i < $maxRemotesCount; $i++) {
                    $sheet->setCellValueByColumnAndRow(
                        $columnIndex,
                        $currentRow,
                        $point->remotes[$i]->number ?? ''
                    );
                    $columnIndex++;
                    $sheet->setCellValueByColumnAndRow(
                        $columnIndex,
                        $currentRow,
                        $point->remotes[$i]->description ?? ''
                    );
                    $columnIndex++;
                }
            }

            // Принтеры
            if ($maxPrintersCount > 0) {
                for ($i = 0; $i < $maxPrintersCount; $i++) {
                    $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->printers[$i]->name ?? '');
                    $columnIndex++;
                    $sheet->setCellValueByColumnAndRow(
                        $columnIndex,
                        $currentRow,
                        $point->printers[$i]->serial_number ?? ''
                    );
                    $columnIndex++;
                    $sheet->setCellValueByColumnAndRow(
                        $columnIndex,
                        $currentRow,
                        $point->printers[$i]->description ?? ''
                    );
                    $columnIndex++;
                    $phonesStatus = isset(
                        $point->printers[$i]->is_spare
                    ) ? $point->printers[$i]->is_spare ? 'Есть' : 'Нет' : '';
                    $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $phonesStatus);
                    $columnIndex++;
                }
            }

            // Устройства
            if ($maxDevicesCount > 0) {
                for ($i = 0; $i < $maxDevicesCount; $i++) {
                    $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->devices[$i]->name ?? '');
                    $columnIndex++;
                    $sheet->setCellValueByColumnAndRow(
                        $columnIndex,
                        $currentRow,
                        $point->devices[$i]->description ?? ''
                    );
                    $columnIndex++;
                }
            }

            // Выравнивание и бордеры или заливка для всего ряда
            if ($point->is_active) {
                $sheet->getStyleByColumnAndRow(1, $currentRow, $columnIndex - 1, $currentRow)
                    ->applyFromArray($tableBodyStyle);
            } else {
                $sheet->getStyleByColumnAndRow(1, $currentRow, $columnIndex - 1, $currentRow)
                    ->applyFromArray($tableBodyStyleNotActive);
            }

            $currentRow++;
        }

        // Экспорт полученных данных
        $exportPath = 'exports/main/';
        $filename = 'Общая_выгрузка_' . uniqid('', false) . '.xlsx';
        try {
            $writer = IOFactory::createWriter($spreadsheet, "Xlsx");

            ob_start();
            $writer->save('php://output');
            $content = ob_get_contents();
            ob_end_clean();

            Storage::disk('public')->put($exportPath . $filename, $content);
            $path = Storage::disk('public')->path($exportPath . $filename);
        } catch (Exception $e) {
            throw new \Exception('Ошибка при экспорте стадий (' . $e->getMessage() . ')');
        }

        return response()->download($path, basename($path));
    }

    /**
     * Выгрузка финансовая
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function exportXls2()
    {
        $defaultStyleArray = array(
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Calibri'
            )
        );

        $staticTitle = [
            '№ п/п',
            'Город',
            'Адрес',
            'Статус точки',
            'Провайдер',
        ];

        $contractTitle = [
            'Номер договора',
            'Владелец',
            'Скорость',
            'Стоимость',
        ];

        $tableHeadStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '000000'
                    ]
                ],
            ],
        ];

        $tableBodyStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '000000'
                    ]
                ],
            ],
        ];

        $tableBodyStyleNotActive = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '000000'
                    ]
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => [
                    'argb' => 'FFA0A0A0',
                ],
            ],
        ];

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator('Мир упаковки')
            ->setLastModifiedBy('Мир упаковки')
            ->setTitle('Мир упаковки - Финансы')
            ->setSubject('Мир упаковки - Финансы')
            ->setDescription('Мир упаковки - Финансы');

        $currentRow = 1;

        $points = Point::with(['contract'])->get();

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getDefaultColumnDimension()->setWidth(18);

        $spreadsheet->getDefaultStyle()
            ->applyFromArray($defaultStyleArray);
        $spreadsheet->getDefaultStyle()->getAlignment()->setWrapText(true);;

        $maxColumn = 1;
        // Шапка для точки
        foreach ($staticTitle as $title) {
            $sheet->setCellValueByColumnAndRow($maxColumn, $currentRow, $title);
            $maxColumn++;
        }

        // Шапка для договора
        foreach ($contractTitle as $title) {
            $sheet->setCellValueByColumnAndRow($maxColumn, $currentRow, $title);
            $maxColumn++;
        }

        $maxColumn--;
        $sheet->getStyleByColumnAndRow(1, $currentRow, $maxColumn, $currentRow)
            ->applyFromArray($tableHeadStyle);

        $currentRow++;

        foreach ($points as $index => $point) {
            // Точки продаж
            $columnIndex = 1;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $index + 1);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->city);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->address);
            $columnIndex++;
            $pointStatus = ($point->is_active) ? '' : 'Закрыта';
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $pointStatus);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->provider);
            $columnIndex++;

            // Договор
            if ($point->contract) {
                $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, "№ " . $point->contract->number);
                $columnIndex++;
                $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->contract->contracts_master);
                $columnIndex++;
                $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->contract->speed);
                $columnIndex++;
                $sheet->setCellValueByColumnAndRow($columnIndex, $currentRow, $point->contract->price);
                $columnIndex++;
            } else {
                $columnIndex += 4;
            }

            // Выравнивание и бордеры или заливка для всего ряда
            if ($point->is_active) {
                $sheet->getStyleByColumnAndRow(1, $currentRow, $columnIndex - 1, $currentRow)
                    ->applyFromArray($tableBodyStyle);
            } else {
                $sheet->getStyleByColumnAndRow(1, $currentRow, $columnIndex - 1, $currentRow)
                    ->applyFromArray($tableBodyStyleNotActive);
            }

            $currentRow++;
        }

        // Экспорт полученных данных
        $exportPath = 'exports/main/';
        $filename = 'Фин_выгрузка_' . uniqid('', false) . '.xlsx';
        try {
            $writer = IOFactory::createWriter($spreadsheet, "Xlsx");

            ob_start();
            $writer->save('php://output');
            $content = ob_get_contents();
            ob_end_clean();

            Storage::disk('public')->put($exportPath . $filename, $content);
            $path = Storage::disk('public')->path($exportPath . $filename);
        } catch (Exception $e) {
            throw new \Exception('Ошибка при экспорте стадий (' . $e->getMessage() . ')');
        }

        return response()->download($path, basename($path));
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
        $output = shell_exec("ping $ip -n 4");
        $latency = iconv("cp866", "utf-8", $output);

        return ['message' => __($latency)];
    }
}
