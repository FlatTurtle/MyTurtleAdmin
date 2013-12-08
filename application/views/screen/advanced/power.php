<div class="row">
    <div class="span12">
        <form class="form-horizontal center power">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                <li><a id="btn-day-schedule" href="#day-schedule" data-toggle="tab">Advanced</a></li>
            </ul>

            <div class="tab-content">

                <!-- general power settings -->
                <div class="tab-pane active" id="general">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Day</th>
                            <th>On</th>
                            <th>Period</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="day">
                            <td>Monday</td>
                            <td><input type="checkbox"></td>
                            <td><input type="text" class="input-small timepicker-from"> to <input type="text"  class="input-small timepicker-to"></td>
                        </tr>
                        <tr class="day">
                            <td>Tuesday</td>
                            <td><input type="checkbox"></td>
                            <td><input type="text" class="input-small timepicker-from"> to <input type="text"  class="input-small timepicker-to"></td>
                        </tr>
                        <tr class="day">
                            <td>Wednesday</td>
                            <td><input type="checkbox"></td>
                            <td><input type="text" class="input-small timepicker-from"> to <input type="text"  class="input-small timepicker-to"></td>
                        </tr>
                        <tr class="day">
                            <td>Thursday</td>
                            <td><input type="checkbox"></td>
                            <td><input type="text" class="input-small timepicker-from"> to <input type="text"  class="input-small timepicker-to"></td>
                        </tr>
                        <tr class="day">
                            <td>Friday</td>
                            <td><input type="checkbox"></td>
                            <td><input type="text" class="input-small timepicker-from"> to <input type="text"  class="input-small timepicker-to"></td>
                        </tr>
                        <tr class="day">
                            <td>Saturday</td>
                            <td><input type="checkbox"></td>
                            <td><input type="text" class="input-small timepicker-from"> to <input type="text"  class="input-small timepicker-to"></td>
                        </tr>
                        <tr class="day">
                            <td>Sunday</td>
                            <td><input type="checkbox"></td>
                            <td><input type="text" class="input-small timepicker-from"> to <input type="text"  class="input-small timepicker-to"></td>
                        </tr>
                        </tbody>
                    </table>



                </div>

                <!-- Advanced scheduling -->
                <div class="tab-pane" id="day-schedule">
                    <p>Enable or disable the screen on specific dates.</p>
                    <div id="dp"></div>
                </div>

            </div>

            <div class="control-group">
                <button id="power-save" class="btn">Save</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    (function(){
        $( document ).ready(function() {
            //initiate calendar on tab click otherwise the width and height are 0
            $('.nav-tabs a[data-toggle="tab"]').on('shown', function (e){
                var $dp = $("#dp");
                if($dp.text() == '' && e.target.id == "btn-day-schedule"){
                    $dp.DatePicker({
                        mode: 'multiple',
                        inline: true,
                        calendars: 3
                    });
                }
            });

            $(".day").each(function(){
                var $from = $(".timepicker-from", this);
                var $to = $(".timepicker-to", this);
                $from.timepicker({
                    onSelect: function(time, instance){
                        $to.timepicker('option', {
                            minTime: {
                                hour: instance.hours,
                                minute: instance.minutes
                            }
                        });
                    }
                });
                $to.timepicker({
                    onSelect: function(time, instance){
                        $from.timepicker('option', {
                            maxTime: {
                                hour: instance.hours,
                                minute: instance.minutes
                            }
                        });
                    }
                })
            });

        });
    }());
</script>