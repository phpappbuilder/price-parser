<?php
namespace App\my\example;
ini_set("memory_limit", "512M");


use App\phpappbuilder\controller\Controller;
use \Symfony\Component\HttpFoundation\Response;
use App\phpappbuilder\template\Template;
use App\phpappbuilder\admin\Template as AdminTemplate;

class TestController extends Controller
{
    public function pt()
        {
           /* bdump($this->request->request->get('forma'), 'содержимое формы');
            $t_con = new \App\phpappbuilder\helpers\Helpers\Collection(['name'=>'Пездюки']);
            $t_con->setHelper('item_1', new \App\phpappbuilder\helpers\Helpers\Text(['label'=>'Имя пездюка', 'placeholder'=>'Как зовут твоего пездюка?', 'required'=>'']));
            $t_con->setHelper('time', new \App\phpappbuilder\helpers\Helpers\Time(['label'=>'Время пездюка', 'required'=>'']));
            $t_con->setHelper('color', new \App\phpappbuilder\helpers\Helpers\Color(['label'=>'Цвет пездюка', 'required'=>'']));
            $t_con->setHelper('sex', new \App\phpappbuilder\helpers\Helpers\Radio(['label'=>'Пол пездюка', 'required'=>'', 'data'=>['men'=>'Мужской', 'women'=>"Женский"]]));
            $t_con->setHelper('pidor', new \App\phpappbuilder\helpers\Helpers\Checkbox(['label'=>'Дать леща пездюку',]));
            $t_con->setHelper('ttr', new \App\phpappbuilder\helpers\Helpers\CheckboxGroup(['label'=>'Признаки пездюка', 'data'=>['pidor'=>'Гавно', 'ne'=>"Няша", 'nez'=>"Гавняша"]]));
            $t_con->setHelper('text', new \App\phpappbuilder\helpers\Helpers\Wysiwyg(['label'=>'Рассказ о пездюке', 'required'=>'']));


            $test_collection=new \App\phpappbuilder\helpers\Helpers\Collection(['name'=>'Test collection']);
            $test_collection->setHelper('item_1', new \App\phpappbuilder\helpers\Helpers\Text(['label'=>'first_fu**ing_input', 'placeholder'=>'Please write text now!']));
            $test_collection->setHelper('pezdyuki', $t_con);

            $collection = new \App\phpappbuilder\helpers\Helpers\Collection(['name'=>'Test collection']);
            $collection->setHelper('item_1', new \App\phpappbuilder\helpers\Helpers\Text(['label'=>'first_fu**ing_input', 'placeholder'=>'Please write text now!']));
            $collection->setHelper('item_2', new \App\phpappbuilder\helpers\Helpers\Text(['label'=>'Prosto tak', 'placeholder'=>'Please write text now!']));
            $collection->setHelper('item_3', $test_collection);
            $form = new Form(['title'=>'My test form', 'submit'=>true, 'description'=>'this is test description' ,
                'form'=>[
                        'method'=>'post',
                        'action'=>Router::url('MyExampleFirstRoute',[])
                ]
            ]);
            $form->setHelper('item_1', new \App\phpappbuilder\helpers\Helpers\Textarea(['label'=>'first_fu**ing_input', 'placeholder'=>'Please write text now!', 'required'=>'']))
                ->setHelper('pass', new \App\phpappbuilder\helpers\Helpers\Password(['label'=>'Password', 'placeholder'=>'Please write password']))
            ->setHelper('item_collection', $collection)
            ->setHelper('text', new \App\phpappbuilder\helpers\Helpers\Wysiwyg(['label'=>'Рассказ о пездюке', 'required'=>'']))
            ->setPrefix('forma');

            if($this->request->request->has('forma')){$form->setData($this->request->request->get('forma'));}
                */

            $category = [];
            $tek_kategory=0;
            $position=[];




            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
            $reader->setReadDataOnly(TRUE);
            $spreadsheet = $reader->load("assets/price.xls");

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
                                $category[]=['id'=>$arr[1], 'name'=>$arr[3]];
                                $tek_kategory=$arr[1];
                            }
                            else{
                                $position[] = [
                                    'id'=>$arr[2],
                                    'name'=>$arr[3],
                                    'categoryId'=>$tek_kategory,
                                    'price'=>$arr[5],
                                    'image'=>ParsePhoto::parse($arr[2])?ParsePhoto::parse($arr[2]):'',
                                    'vendor'=>$arr[6]
                                ];
                            }
                }
                $cd++;
                if ($cd>=50){break;}
            }
            unset($reader);
            unset($spreadsheet);
            unset($worksheet);
            $tktk='';

            foreach($position as $value){
                $tktk.='<tr>';
                    foreach($value as $key => $items){
                        $tktk.='<td>';
                            $tktk.=($key=='image')?'<img src="'.$items.'" width="100">':$items;
                        $tktk.='</td>';
                    }

                $tktk.='</tr>';
            }

            $template = new Template( AdminTemplate::class );
            $this->response->setContent($template
                ->render('index', [
                    'title' => 'Centurion app',
                    'sidebar'=>$template->render('component/sidebar' , [
                        'section' => $template->render('component/sidebar/section', [
                            'section' => [[
                                'name' => 'Раздел разработки',
                                'collection' => [
                                    $template->render('component/sidebar/item', [
                                        'fa_icon'=>'fa fa-laptop',
                                        'name'=>'TEst item!',
                                        'href'=>'/admin',
                                        'badges'=>[
                                            ['color'=>'green' , 'value'=>'yes!']
                                        ]
                                    ])
                                ]
                            ],
                                [
                                    'name' => 'Раздел разработки',
                                    'collection' => [
                                        $template->render('component/sidebar/item', [
                                            'fa_icon'=>'fa fa-laptop',
                                            'name'=>'TEst item!',
                                            'href'=>'/admin',
                                            'badges'=>[
                                                ['color'=>'green' , 'value'=>'yes!']
                                            ],
                                            'child'=>[
                                                $template->render('component/sidebar/item', [
                                                    'fa_icon'=>'fa fa-laptop',
                                                    'name'=>'TEst item!',
                                                    'href'=>'/admin',
                                                    'badges'=>[
                                                        ['color'=>'green' , 'value'=>'yes!']
                                                    ],
                                                    'child'=>[
                                                        $template->render('component/sidebar/item', [
                                                            'fa_icon'=>'fa fa-laptop',
                                                            'name'=>'TEst item!',
                                                            'href'=>'/admin',
                                                            'badges'=>[
                                                                ['color'=>'green' , 'value'=>'yes!']
                                                            ]
                                                            ])
                                                    ]
                                                ])
                                            ]
                                        ])
                                    ]
                                ]
                            ]
                        ])
                    ]),
                    'header' => $template->render('component/header', [
                        'auth'=>$template->render('component/header/auth',['user'=>'sergey_golev', 'actions'=>[
                            ['href'=>'/profile' , 'name'=>'Profile'],
                            ['href'=>'/setting' , 'name'=>'Setting'],
                            ['href'=>'/logout' , 'name'=>'logout']
                        ]]),
                        'LogoSmall'=>'<b>app</b>',
                        'LogoBig'=>'<b>Centurion</b>App',
                        'dropdown'=>[['fa_icon'=>'fa fa-cloud-download', 'label'=>'new!' , 'label_type'=>'warning' , 'header'=>'hello world', 'content'=>'<a href="/admin">Click this</a>' , 'footer'=> '<a href="#">See All Messages</a>']]
                    ]),
                    'content_header'=>$template->render('component/content/header', [
                        'title'=>'Hello world app',
                        'description'=>'This is first application build of this framework',
                        'breadcrumbs'=>[
                            ['value'=>'<a href="#"><i class="fa fa-dashboard"></i> Home</a>'],
                            ['value'=>'<a href="#">Layout</a>'],
                            ['value'=>'Collapsed Sidebar', 'active'=>true]
                        ]
                    ]),
                    'content'=>'
                    <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Bordered Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tbody>
                '.$tktk.'
              </tbody></table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
            </div>
          </div>
                    ',
                    'footer'=>$template->render('component/footer', [
                        'text'=>'    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.'
                    ])
            ]));

            //$this->response->setContent('<html><body><h1>Hello world.'.$this->arg['trans'].'</h1><a href="'.Router::url($this->route , ['trans'=>'sergey']).'">this route - '.$this->route.'</a></body></html>'.);
            $this->response->setStatusCode(Response::HTTP_OK);
            $this->response->headers->set('Content-Type', 'text/html');
            $this->response->send();

        }
}