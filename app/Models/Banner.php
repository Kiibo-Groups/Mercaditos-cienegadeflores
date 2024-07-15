<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;

class Banner extends Authenticatable
{
    protected $table = "banner";

     /*
    |--------------------------------------
    |Add/Update Data
    |--------------------------------------
    */
    public function addNew($data,$type)
    {
        $add                    = $type === 'add' ? new Banner : Banner::find($type);
        $add->status            = isset($data['status']) ? $data['status'] : 0;
        $add->url               = isset($data['url']) ? $data['url'] : 'null';
        $add->position          = isset($data['position']) ? $data['position'] : 0;

        if(isset($data['img']))
        {
            // Eliminamos imagen anterior
            if ($type != 'add') {
            	unlink("upload/banner/".$add->img);
            }

            $filename   = time().rand(111,699).'.' .$data['img']->getClientOriginalExtension(); 
            $data['img']->move("upload/banner/", $filename);   
            $add->img = $filename;   
        }

        $add->save();
    }

    /*
    |--------------------------------------
    |Get all data from db
    |--------------------------------------
    */
    public function getAll($city = 0,$type = 'all')
    {
        return Banner::where(function($query) use($city,$type){

            if($type !== 'all')
            {
                $query->where('banner.position',$type);
            }

            if($city > 0)
            {
                $query->where('banner.status',0)->whereIn('banner.city_id',[0,$city]);
            }


        })->leftjoin('city','banner.city_id','=','city.id')
                     ->select('city.name as city','banner.*')
                     ->orderBy('id','DESC')->get();
    }

    public function getPosition($type)
    {
        if($type == 0)
        {
            $return = "Top";
        }
        elseif($type == 1)
        {
            $return = "Middle";
        }
        else
        {
            $return = "Bottom";
        }

        return $return;
    }

    public function getAppDataTop()
    {
        $data = [];
        $req  = Banner::where('status',0)->where('position',0)->get();

        foreach($req as $row)
        {
            $data[] = [
                'id'        => $row->id,
                'img'       => Asset('upload/banner/'.$row->img),
                'link'      => $row->url,
                'pos'       => $this->getPosition($row->position)  
            ];
        }

        return $data;
    }

    public function getAppDataMiddle()
    {
        $data = [];
        $req  = Banner::where('status',0)->where('position',1)->get();

        foreach($req as $row)
        {
            $data[] = [
                'id'        => $row->id,
                'img'       => Asset('upload/banner/'.$row->img),
                'link'      => $row->url,
                'pos'       => $this->getPosition($row->position)  
            ];
        }

        return $data;
    }
}
