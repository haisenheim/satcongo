<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Contrat;
use App\Models\Cooperative;
use App\Models\Livraison;
use App\Models\Protocole;
use App\Models\Saison;
use App\Models\Secteur;
use Illuminate\Http\Request;

class DashboardController extends Controller
{



    public function index()
	{
        $saisons = Saison::where('active',1)->get();
        $sids = $saisons->pluck('id');
        $contrats = Contrat::whereIn('saison_id',$sids)->get();
        $protocoles = Protocole::whereIn('saison_id',$sids)->get();
        $gp = $protocoles->groupBy(function($item){
            return $item->id .'~'.$item->cooperative->name.'~'.$item->cooperative->photo;
        })->keys();
        $gp = $gp->map(function($v,$i){
            $v = explode('~',$v);
            return [
                'id'=>$v[0],
                'name'=>$v[1],
                'photo'=>$v[2],
            ];
        });

        $gc = $contrats->groupBy(function($item){
            return $item->id .'~'.$item->client->name.'~'.$item->client->photo;
        })->keys();
        $gc = $gc->map(function($v,$i){
            $v = explode('~',$v);
            return [
                'id'=>$v[0],
                'name'=>$v[1],
                'photo'=>$v[2],
            ];
        });

        //dd($gp);

		return view('Admin/dashboard',compact('gp','gc'));
	}

    public function getLivraisons(){
        $client_id = request()->client_id;
        $cooperative_id = request()->cooperative_id;
        $saisons = Saison::where('active',1)->get();
        $sids = $saisons->pluck('id');
        $livraisons = Livraison::whereIn('saison_id',$sids)->where('client_id',$client_id)->where('cooperative_id',$cooperative_id)->whereNotNull('delivered_At')->get();
        $qty = $livraisons->reduce(function($carry,$item){
            return $carry + $item->quantity;
        });
        $qty = $qty?$qty:0;

        $price = $livraisons->reduce(function($carry,$item){
            return $carry + $item->quantity * $item->price * 1000;
        });
        $price = $price?$price:0;
        $qty = $qty?$qty:0;
        $data = [
            'qty'=>$qty,
            'price'=>number_format($price,0,',','.')
        ];
        return response()->json($data);
    }

    public function getData()
    {
        $saisons = Saison::where('active',1)->get();
        $sids = $saisons->pluck('id');
        $contrats = Contrat::whereIn('saison_id',$sids)->get();
        $protocoles = Protocole::whereIn('saison_id',$sids)->get();
        $livraisons = Livraison::whereIn('saison_id',$sids)->get();
        //$liv_nv = $livraisons->whereNull('accepted_at');
        //$liv_v = $livraisons->whereNotNull('accepted_at')->whereNull('delivered_at');

        $glvcs = $livraisons->groupBy(function($item){
            return $item->client->name;
        });

        $glvps = $livraisons->groupBy(function($item){
            return $item->cooperative->name;
        });

        $glvcs = $glvcs->map(function($v,$i)use($contrats){
            $_liv_nv = $v->whereNull('accepted_at');
            $_liv_v = $v->whereNotNull('accepted_at')->whereNull('delivered_at');
            $_liv_d = $v->whereNotNull('delivered_at');
            $qtnv = $_liv_nv->reduce(function($c,$it){
                return $c+$it->quantity;
            });
            $qtv = $_liv_v->reduce(function($c,$it){
                return $c+$it->quantity;
            });
            $qtd = $_liv_d->reduce(function($c,$it){
                return $c+$it->quantity;
            });

            $client = Client::where('name',$i)->first();
            $cts = $contrats->where('client_id',$client->id);
            $qt = $cts->reduce(function($c,$item){
                return $c + $item->quantity;
            });

            return [
                'client'=>$i,
                'qty'=>$qt,
                'nv'=>$qtnv?$qtnv:0,
                'nl'=>$qtv?$qtv:0,
                'l'=>$qtd?$qtd:0
            ];
        });

        $glvps = $glvps->map(function($v,$i)use($protocoles){
            $_liv_nv = $v->whereNull('accepted_at');
            $_liv_v = $v->whereNotNull('accepted_at')->whereNull('delivered_at');
            $_liv_d = $v->whereNotNull('delivered_at');
            $qtnv = $_liv_nv->reduce(function($c,$it){
                return $c+$it->quantity;
            });
            $qtv = $_liv_v->reduce(function($c,$it){
                return $c+$it->quantity;
            });
            $qtd = $_liv_d->reduce(function($c,$it){
                return $c+$it->quantity;
            });

            $client = Cooperative::where('name',$i)->first();
            $cts = $protocoles->where('cooperative_id',$client->id);
            $qt = $cts->reduce(function($c,$item){
                return $c + $item->quantity;
            });
            return [
                'producteur'=>$i,
                'nv'=>$qtnv?$qtnv:0,
                'nl'=>$qtv?$qtv:0,
                'l'=>$qtd?$qtd:0,
                'qty'=>$qt
            ];
        });

        $qtyc = $contrats->reduce(function($c,$i){
            return $c + $i->quantity;
        });

        $qtyp = $protocoles->reduce(function($c,$i){
            return $c + $i->quantity;
        });

        $gp = $protocoles->groupBy(function($item){
            return $item->cooperative->name;
        });

        $gp = $gp->map(function($v,$i){
            return [
                'producteur'=>$i,
                'quantity'=>$v->reduce(function($c,$it){
                    return $c + $it->quantity;
                })
            ];
        });

        $gc = $contrats->groupBy(function($item){
            return $item->client->name;
        });

        $gc = $gc->map(function($v,$i){
            return [
                'client'=>$i,
                'quantity'=>$v->reduce(function($c,$it){
                    return $c + $it->quantity;
                })
            ];
        });

        return response()->json([
            'client'=>$glvcs->values(),
            'producteur'=>$glvps->values(),
            'qtyc'=>$qtyc,
            'qtyp'=>$qtyp,
            'tngp'=>$gp->values(),
            'tngc'=>$gc->values(),
        ]);

    }

    public function _getData()
    {
        $saisons = Saison::where('active',1)->get();
        $sids = $saisons->pluck('id');
        $contrats = Contrat::whereIn('saison_id',$sids)->get();
        $protocoles = Protocole::whereIn('saison_id',$sids)->get();
        $livraisons = Livraison::whereIn('saison_id',$sids)->get();
        $liv_nv = $livraisons->whereNull('accepted_at');
        $liv_v = $livraisons->whereNotNull('accepted_at')->whereNull('delivered_at');
        //$liv_nd = $liv_v;
        $liv_d = $liv_v->whereNotNull('delivered_at');

        $tc = $contrats->reduce(function($carry,$item){
            return $carry + $item->quantity;
        });
        $tp = $protocoles->reduce(function($carry,$item){
            return $carry + $item->quantity;
        });

        $grp_nvc = $liv_nv->groupBy(function($item){
            return $item->contrat->client->name;
        });

        $grp_vc = $liv_v->groupBy(function($item){
            return $item->contrat->client->name;
        });

        /* $grp_ndc = $liv_nd->groupBy(function($item){
            return $item->contrat->client->name;
        }); */

        $grp_dc = $liv_d->groupBy(function($item){
            return $item->contrat->client->name;
        });

        $grp_nvp = $liv_nv->groupBy(function($item){
            return $item->protocole->cooperative->name;
        });

        $grp_vp = $liv_v->groupBy(function($item){
            return $item->protocole->cooperative->name;
        });

       /*  $grp_ndp = $liv_nd->groupBy(function($item){
            return $item->protocole->cooperative->name;
        }); */

        $grp_dp = $liv_d->groupBy(function($item){
            return $item->protocole->cooperative->name;
        });

        $reliquat = $tp - $tc;
        $qtc = $contrats->count();
        $qtp = $protocoles->count();

        return response()->json([
            'tc'=>$tc,
            'tp'=>$tp,
            'livraisons'=>$livraisons,
            'liv_nv'=>$liv_nv,
            'liv_v'=>$liv_v,
            //'liv_nd'=>$liv_nd,
            'liv_d'=>$liv_d,
            'labels'=>[
                'nv'=>'non valide',
                'v'=>'valide',
                'nv'=>'non livre',
                'd'=>'livre',
            ],
            'datasets'=>[
                'label'=> "Commandes clients",
                'data'=> [
                    'nv'=>$grp_nvc->map(function($v,$i){
                        return $v->count();
                    }),
                    'v'=>$grp_vc->map(function($v,$i){
                        return $v->count();
                    }),
                   /*  'nd'=>$grp_ndc->map(function($v,$i){
                        return $v->count();
                    }), */
                    'd'=>$grp_dc->map(function($v,$i){
                        return $v->count();
                    }),
                ],
                'borderColor'=> '#456e43',
                'backgroundColor'=> '#456e43',
                'parsing'=>[
                   'xAxisKey'=>"y",
                   'yAxisKey'=>"a"
                ]
            ],
            'groups'=>[
                'clients'=>[
                    'nv'=>$grp_nvc->map(function($v,$i){
                        return $v->count();
                    }),
                    'v'=>$grp_vc->map(function($v,$i){
                        return $v->count();
                    }),
                    /* 'nd'=>$grp_ndc->map(function($v,$i){
                        return $v->count();
                    }), */
                    'd'=>$grp_dc->map(function($v,$i){
                        return $v->count();
                    }),
                ],
                'producteurs'=>[
                    'nv'=>$grp_nvp->map(function($v,$i){
                        return $v->count();
                    }),
                    'v'=>$grp_vp->map(function($v,$i){
                        return $v->count();
                    }),
                    //'nd'=>$grp_ndp,
                    'd'=>$grp_dp,
                ],
            ]
        ]);


    }
}
