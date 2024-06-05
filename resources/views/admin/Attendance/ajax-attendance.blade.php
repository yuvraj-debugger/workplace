
<?php 

use App\Models\UserAttendance;
use App\Models\Holiday;

$date=[];
for($day=0;$day<$days;++$day)
{
    $day_=$day+1;
    $date[]=strtotime($year . '-' . $month . '-' . $day_);
}
$holiday=Holiday::select('date')->get()->pluck('date')->toArray();
?>
         @foreach($userData as $user)
          
                                   	<tr>
                                   		<td>
                                    		<div class="user-name">
                                                <div class="user-image">
                                                    <img src="{{($user->photo)?$user->photo:asset('/images/user.png')}}" alt="user-img" />
                                                </div>
                                                <span class="green"><a href="employee-profile/{{$user->_id}}">{{ $user->first_name.' '.$user->last_name}} ({{$user->employee_id}})</a></span>
                                            </div>
                                    	</td>
                                    	<?php 
                                    	
                                    	$attendance=UserAttendance::select('date')->where('user_id', $user->_id)->whereIn('date',$date)->get()->pluck('date')->toArray();
                                    	
                                    	?>
                                    	@for($day=0;$day<$days;++$day)
                                    		<?php 
                                    		
                                    		$day_=$day+1;
                                    		$date_today=strtotime($year . '-' . $month . '-' . $day_);
                                    		
                                    		?>
                                		<td>
                                		<?php
                                		if((date('w',$date_today) == 6)||(date('w',$date_today) == 0)){
                                		    ?>
                                		    <img src="{{(date('w',$date_today) == 6)?asset ('images/summer-holidays.png'):asset ('images/luggage.webp')}}" alt="" width="24px">
                                		    
                              <?php   		}elseif (in_array($date_today,$holiday)){
                              ?> <span>H</span>
                          <?php    } else{ $xleave = $user->getLeaves($date_today)?>
                                        @if($xleave)
                                			<span class="present">{{$xleave}}</span>
                                		@elseif(in_array($date_today,$attendance))
                                				<span class="present">P</span>
                            			@elseif($day < date('d'))
                                			<span data-bs-toggle="modal" data-bs-target="#attendanceModal"  onclick="editAttendance('{{$user->_id}}','{{($day_)}}')" class="absent" style="cursor:pointer">A</span>
										@else
                                			<span>-</span>
                            			@endif
                                		<?php }?>
                                    	</td>
                                    	@endfor
                                    	
                                   	</tr>
                                    @endforeach