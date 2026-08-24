<?php

namespace App\Services\File;

use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Common\Type;
use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class XlsxService
{
    public static function getXlsx($path, $fileName)
    {
        $reader = ReaderFactory::createFromType(Type::XLSX);
        $reader->setShouldFormatDates(false); // default value
        $reader->setShouldFormatDates(true); // will return formatted dates

        $reader->open($path . $fileName);

        $array_data = [];

        foreach ($reader->getSheetIterator() as $key => $sheet) {
            $array_data[$key] = [];
            foreach ($sheet->getRowIterator() as $i => $row) {
                $val = $row->toArray();

                array_push($array_data[$key], $val);

            }

        }

        $reader->close();

        return $array_data;
    }

    public static function generateXlsx($cabecera, $data, $path, $filename)
    {
        $writer = WriterEntityFactory::createXLSXWriter();
       
        $writer->openToFile($path.$filename);

        /** Create a style with the StyleBuilder */
        $style = (new StyleBuilder())
            ->setFontBold()
            ->setCellAlignment(CellAlignment::CENTER)
            ->setBackgroundColor(Color::YELLOW)
            ->build();

        /** Create a row with cells and apply the style to all cells */
        $row = WriterEntityFactory::createRowFromArray($cabecera, $style);

        /** Add the row to the writer */
        $writer->addRow($row);

        foreach($data as $fila){
            $acelda  = [];
            foreach($fila  as $key => $celda){
                $acelda[] = $celda;
            }    
          
            $writer->addRow(WriterEntityFactory::createRowFromArray($acelda));
        }

        $writer->close();
    }
}
