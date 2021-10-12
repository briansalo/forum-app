<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
   public function getRouteKeyName() //same rane siyag explanation dedtoa sa model sa discussion.php g butang lang sab nako siya derea kay dedtoa sa discussioncontroller sa method nga indexchannel kay ang g basehan raba dedto kay slug dili ang channel i.d. so g butang sab nao ne siya dere aron dili ta mag not found 
    {
    	return 'slug';
    }
}
