<?php

namespace App;
use App\Discussion;

class Discussion extends Model
{
    public function author()
    {
    	return $this->belongsTo(User::class, 'user_id'); // kung ang function nimo is dili e pareha sa class make sure nga ang second parameter kay g butang nimo ang foreign key
    }

    public function replies()
    {
    	return $this->hasMany(Reply::class);
    }

    public function watches()
    {
        return $this->hasMany(Watch::class);
    }

    public function getRouteKeyName() // kani nga method aron basahon ne laravel sa database ang naka slug. so aron dedto sa discussion controller show method mo gana to siya kay nag base man to sa slug dili sa i.d.
    {
    	return 'slug';
    }

    public function getbestReply() //belongs to method ang g gamit kay total sa discussion table isa raman ka sa i.d. sa reply_id column
    {
       return $this->belongsTo(Reply::class, 'reply_id');

    }

    public function bestreply(Reply $reply) // gikan
    { 
        return $this->update([
            'reply_id' =>$reply->id
        ]);
    }

    public function is_been_watched_by_user()
    {
        $watchers_id = array(); //nag declare dere og varible derea e butang ang mga array

         foreach($this->watches as $watch): //ang $this watches mao nang  method nga nag define nga discussion has many watch then g butang siya sa $watch nga variable then nag for loop dayon aron ma gawas tanan ang sulod sa watches method aron makitan kinsay mga user nga nag watch

            array_push($watchers_id, $watch->user->id);//then derea tanan id nga na for loop e save niya sa $watchers_id aron kadtong g declare nato nga variable sa top which is $watchers_id naa nato siyay sulod
         endforeach;   

         if(in_array(auth()->user()->id, $watchers_id))// if ang id sa authentication user is nag exist dedtoa sa array e return niya og true so this way mabalan nato kung ang authenticatio user is nag watch naba ane nga discussion
         {
            return true;
         }
         else{
            return false;
         }
    }
}
