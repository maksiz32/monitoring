<?php

namespace App\Http\Controllers\Points;

use App\Http\Controllers\Controller;
use App\Http\Requests\PointRequest;
use App\Models\Contract;
use App\Models\Point;
use App\Models\RemoteControl;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
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
//dd($point);
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

    public function exportXls()
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator('Мир упаковки')
            ->setLastModifiedBy('Мир упаковки')
            ->setTitle('Мир упаковки - Точки')
            ->setSubject('Мир упаковки - Точки')
            ->setDescription('Мир упаковки - Точки');

        $staticTitle = [
            'Город',
            'Адрес',
            'Статус',
            'Роутер',
            'LAN IP',
            'VPN',
            'WAN IP',
            'Статус телефонии',
            'Провайдер',
            'Логин',
            'На кого договор',
            'Скорость',
            'Стоимость',
            'Логин PPPoE',
            'Номер договора',
            'ИБП'
        ];

        // Получить максимальные значения связанных данных
        $points = Point::with(['printers', 'devices', 'remotes'])->get();
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
        $sheet->setCellValue('A1', 'id стадии');
        $sheet->getColumnDimensionByColumn(1)->setWidth(10);
        $sheet->setCellValue('B1', 'Начало стадии');
        $sheet->mergeCells('B1:E1');
        $sheet->getStyle('B1')->applyFromArray([
                                                   'alignment' => [
                                                       'horizontal' => Alignment::HORIZONTAL_CENTER,
                                                       'vertical' => Alignment::VERTICAL_CENTER,
                                                       'wrapText' => true,
                                                   ],
                                               ]);
        $sheet->setCellValue('F1', 'Окончание стадии');
        $sheet->mergeCells('F1:I1');
        $sheet->getStyle('F1')->applyFromArray([
                                                   'alignment' => [
                                                       'horizontal' => Alignment::HORIZONTAL_CENTER,
                                                       'vertical' => Alignment::VERTICAL_CENTER,
                                                       'wrapText' => true,
                                                   ],
                                               ]);
        $sheet->setCellValue('B2', 'Месяц');
        $sheet->setCellValue('C2', 'День');
        $sheet->setCellValue('D2', 'Час');
        $sheet->setCellValue('E2', 'Минута');
        $sheet->setCellValue('F2', 'Месяц');
        $sheet->setCellValue('G2', 'День');
        $sheet->setCellValue('H2', 'Час');
        $sheet->setCellValue('I2', 'Минута');
        $sheet->getStyle('B2:I2')->applyFromArray([
                                                      'font' => [
                                                          'bold' => true,
                                                      ],
                                                  ]);
        $lineIndex = 3;
        /*
         * // Максимальное количество элементов в каждом условии
        $maxCountCondition = 3;
        $maxBottomCell = count($data);
        // Столбцы данных
        $newRow = 3;
        $listCondition = ['Текст условия №', 'Действие условия №', 'id перехода №'];
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
        $tableBodyWithBorderRight = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'wrapText' => true
            ],
            'borders' => [
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '000000'
                    ]
                ],
            ],
        ];
        $defaultStyleArray = array(
            'font'  => array(
                'color' => array('rgb' => '000000'),
                'size'  => 12,
                'name'  => 'Calibri'
            ));

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator('Quizer')
            ->setLastModifiedBy('Quizer')
            ->setTitle('Quizer экспорт предусловий')
            ->setSubject('Quizer экспорт предусловий')
            ->setDescription('Quizer экспорт предусловий');
        $spreadsheet->getDefaultStyle()
            ->applyFromArray($defaultStyleArray);

        $sheet = $spreadsheet->getActiveSheet();

        // Шапка таблицы
        $sheet->setCellValue('A1', 'id');
        $sheet->mergeCells('A1:A2');
        $sheet->getStyleByColumnAndRow(1, 1, 1, 2)->applyFromArray($tableHeadStyle);
        $sheet->getColumnDimensionByColumn(2)->setWidth(45);
        $sheet->setCellValue('B1', 'Текст');
        $sheet->mergeCells('B1:B2');
        $sheet->getStyleByColumnAndRow(2, 1, 2, 2)->applyFromArray($tableHeadStyle);
        // Определить максимальное количество условий для того, чтобы сразу отрисовать шапку
        $maxPreCondition = self::getMaximumPreconditions($data);
        $coordinate = 2;

        for ($step = 1; $step <= $maxPreCondition; $step++) {
            $sheet->setCellValueByColumnAndRow($coordinate + 1, 1, "Условие №$step");

            for ($i = 0; $i < $maxCountCondition; $i++) {
                $sheet->setCellValueByColumnAndRow($coordinate + 1 + $i, 2, $listCondition[$i] . $step);
                $sheet->getStyleByColumnAndRow($coordinate + 1 + $i, 2)->applyFromArray($tableHeadStyle);

                // Задаю ширину колонкам
                if ($i < $maxCountCondition - 1) {
                    $sheet->getColumnDimensionByColumn($coordinate + 1 + $i)->setWidth(25);
                } else {
                    $sheet->getColumnDimensionByColumn($coordinate + 1 + $i)->setWidth(9);
                    $sheet->getStyleByColumnAndRow($coordinate + 1 + $i, $newRow, $coordinate + 1 + $i, 999)
                        ->applyFromArray($tableBodyWithBorderRight);
                }
                // Добавление проверки по списку
                if ($i === 1) {
                    $validation = $sheet->getCellByColumnAndRow($coordinate + 1 + $i, $newRow)->getDataValidation();
                    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Ошибка ввода');
                    $validation->setError('Значение не из списка выбора.');
                    $validation->setPromptTitle('Выберите из списка');
                    $validation->setPrompt('Выберите из выпадающего списка.');
                    $validation->setFormula1('"перейти к,показать"');
                    // Клонирую список проверки по количеству элементов вниз
                    for ($j = $newRow + 1; $j <= $maxBottomCell; $j++) {
                        $sheet->getCellByColumnAndRow($coordinate + 1 + $i, $j)->setDataValidation(clone $validation);
                    }
                }
            }
            // Закрепление областей таблицы
            $sheet->freezePane('B3');

            $oldCoordinate = $coordinate;
            $coordinate += 3;

            $sheet->mergeCellsByColumnAndRow($oldCoordinate + 1, 1, $coordinate, 1);
            $sheet->getStyleByColumnAndRow($oldCoordinate + 1, 1, $coordinate, 1)->applyFromArray($tableHeadStyle);
        }

        foreach ($data as $datum) {
            $columnIndex = 1;
            $sheet->setCellValueByColumnAndRow($columnIndex, $newRow, $datum['id']);
            $sheet->getStyleByColumnAndRow($columnIndex, $newRow, $columnIndex, 999)->applyFromArray($tableBodyWithBorderRight);
            $columnIndex++;
            $sheet->setCellValueByColumnAndRow($columnIndex, $newRow, $datum['title']);
            $sheet->getStyleByColumnAndRow($columnIndex, $newRow, $columnIndex, 999)->applyFromArray($tableBodyWithBorderRight);
            $columnIndex++;
            if (is_array($datum['pre_condition'])) {
                $precondition = &$datum['pre_condition'];
            } else {
                $precondition = [''];
            }
            // Дополнить массив с предусловиями до длинны самого большого массива (чтобы поля проверки условий сохранились на пустых строках
            $precondition = array_pad($precondition, $maxPreCondition, '');
                foreach ($precondition as $item) {
                    $oneLineCondition = self::parseConditions($item);
                    foreach ($oneLineCondition as $key => $condition) {
                        $sheet->setCellValueByColumnAndRow($columnIndex, $newRow, $condition);
                        $sheet->getStyleByColumnAndRow($columnIndex , $newRow, $columnIndex, $newRow)
                            ->applyFromArray([
                                'alignment' => [
                                  'horizontal' => Alignment::HORIZONTAL_LEFT,
                                  'wrapText' => true
                                ],
                            ]);
                        // Задаю проверку данных из списка
                        if ($key === 1 && (isset($datum['hidden']) && $datum['hidden'])) {
                            $validation = $sheet->getCellByColumnAndRow($columnIndex, $newRow)->getDataValidation();
                            $validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
                            $validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
                            $validation->setAllowBlank(false);
                            $validation->setShowInputMessage(true);
                            $validation->setShowErrorMessage(true);
                            $validation->setShowDropDown(true);
                            $validation->setErrorTitle('Ошибка ввода');
                            $validation->setError('Значение не из списка выбора.');
                            $validation->setPromptTitle('Выберите из списка');
                            $validation->setPrompt('Выберите из выпадающего списка.');
                            $validation->setFormula1('"показать,не показывать"');
                        }
                        $columnIndex++;
                    }
                }
            $newRow++;
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        $Xlsx = new Xlsx($spreadsheet);
        $Xlsx->save('php://output');
        die();
         */
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
        $latency = iconv("cp866","utf-8", $output);

        return ['message' => __($latency)];
    }
}
