<?php

namespace App\my\example\Cli;

ini_set("memory_limit", "512M");

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use \App\my\example\ParsePhoto;
use Spatie\ArrayToXml\ArrayToXml;

class Build extends Command
{
    protected function configure()
    {
        $this
            // имя команды (часть после "bin/console")
            ->setName('price:build')

            // краткое описание, отображающееся при запуске "php bin/console list"
            ->setDescription('Строит прайс для prom.ua')

            // полное описание команды, отображающееся при запуске команды
            // с опцией "--help"
            ->setHelp('Строит прайс для prom.ua')

            // создать аргумент
            ->addArgument('path', InputArgument::REQUIRED, 'путь к прайсу')

            //->addArgument('result', InputArgument::REQUIRED, 'куда сохранить')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Build Your Bundle',
            '===============',
            'Path : '.$input->getArgument('path'),
        ]);



        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, ' ');
        xmlwriter_start_document($xw, '1.0', 'UTF-8');

        xmlwriter_start_element($xw, 'price');
        xmlwriter_start_attribute($xw, 'date');
        xmlwriter_text($xw, date("Y-m-d H:i"));
        xmlwriter_end_attribute($xw);



        xmlwriter_start_element($xw, 'name');
        xmlwriter_text($xw, 'Прайс от славона');
        xmlwriter_end_element($xw);





        $category = [];
        $tek_kategory=0;
        $position=[];

        $new_category=0;
        $new_item=0;
        if(is_file($input->getArgument('path'))){

            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
            $reader->setReadDataOnly(TRUE);
            $spreadsheet = $reader->load($input->getArgument('path'));

            $worksheet = $spreadsheet->getActiveSheet();


            $cd = 0;
            $str_delete=[0,1,2,3,4,5,6,7,8,9];
            foreach ($worksheet->getRowIterator() as $row) {

                if(!in_array($cd, $str_delete)){

                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(FALSE);

                    $i=0;
                    $arr=[];
                    foreach ($cellIterator as $cell) {

                        $arr[$i]=$cell->getValue();
                        $i++;
                    }

                    if ($arr[0]==null){
                        $category[]=['id'=>$cd, 'name'=>$arr[3]];
                        $tek_kategory=$cd;
                        $output->writeln("[new category][".$cd."]". " - " . $arr[3]);
                        $new_category++;
                    }
                    else{
                        $pars_tek=ParsePhoto::parse($arr[2]);
                        if($pars_tek && $pars_tek!=''){
                            $position[] = [
                                'id'=>$cd,
                                'name'=>$arr[3],
                                'categoryId'=>$tek_kategory,
                                'price'=>$arr[5],
                                'image'=>$pars_tek?$pars_tek:'',
                                'vendor'=>$arr[6]
                            ];
                            $output->writeln("[new item][".$cd."]". " - " . $arr[3]);
                            $new_item++;
                        }
                        unset($pars_tek);
                    }
                }
                $cd++;
                if ($cd>=80){break;}
            }
            unset($reader);
            unset($spreadsheet);
            unset($worksheet);


        }


        xmlwriter_start_element($xw, 'catalog');

        foreach($category as $item){
            xmlwriter_start_element($xw, 'category');

            xmlwriter_start_attribute($xw, 'id');
            xmlwriter_text($xw, $item['id']);
            xmlwriter_end_attribute($xw);

            xmlwriter_text($xw, $item['name']);
            xmlwriter_end_element($xw); // category
        }
        xmlwriter_end_element($xw); // catalog

        unset($category);

        xmlwriter_start_element($xw, 'items');
        foreach ($position as $item){
            xmlwriter_start_element($xw, 'item');

            xmlwriter_start_attribute($xw, 'id');
            xmlwriter_text($xw, $item['id']);
            xmlwriter_end_attribute($xw);

                xmlwriter_start_element($xw, 'name');
                    xmlwriter_text($xw, $item['name']);
                xmlwriter_end_element($xw); // name

                xmlwriter_start_element($xw, 'categoryId');
                    xmlwriter_text($xw, $item['categoryId']);
                xmlwriter_end_element($xw); // categoryId

                xmlwriter_start_element($xw, 'price');
                    xmlwriter_text($xw, $item['price']);
                xmlwriter_end_element($xw); // price


                xmlwriter_start_element($xw, 'image');
                    xmlwriter_text($xw, $item['image']);
                xmlwriter_end_element($xw); // image

                xmlwriter_start_element($xw, 'vendor');
                    xmlwriter_text($xw, $item['vendor']);
                xmlwriter_end_element($xw); // vendor

            xmlwriter_end_element($xw); // item
        }
        xmlwriter_end_element($xw); // items
        unset($position);





        xmlwriter_end_element($xw);



        xmlwriter_end_document($xw);



        //file_put_contents('assets/result.xml', xmlwriter_output_memory($xw));
        $output->writeln("[final new items][".$new_item."]");
        $output->writeln("[final new categories][".$new_category."]");
        $output->writeln(xmlwriter_output_memory($xw));

    }
}