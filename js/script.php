<?php
//class for timetable
class PrayerTimetable {
    //response of the api will be stored here
    private $response;
    //data of the api from the response will be stored here
    private $data;
    //pasing the url of the json data here directly, due to the fact that the api is free and unlimited
    private $api_url = "https://api.aladhan.com/v1/calendar/{year}/{month}?latitude=56.47404281844331&longitude=-2.963501315403592&method=3&shafaq=general&tune=5%2C3%2C5%2C7%2C9%2C-1%2C0%2C8%2C-6&timezonestring=UTC&calendarMethod=UAQ";
    //construct class when called will automatically call the api aswell and therefore decode it
    public function __construct()
    {
        //check response of the content
        #$this->response = file_get_contents($this->api_url);

        //need to implement a function that changes the year and month
        $tmp = $this->checkdateandchange();
        //checks if there's anything wrong with the json data before displaying
        $this->response = $this->checkIntegrityOfData($tmp);
        //decodes the json data
        $this->data = json_decode($this->response);
    }

    //checking if the data is working properly if not it will send a message instead
    public function checkIntegrityOfData($item)
    {
        $txt = file_get_contents($item);
        if($txt == FALSE)
        {
            echo "<h1>something is wrong please retry again later</h1> <br>";
            echo "<h1>ERROR 100 - No data or content available</h1>";
        } else {
            return $txt;
        }
    }

    //nearly done need to change a few things for it
    public function checkdateandchange(){
        //echo $this->api_url;
        //echo '<br>--------------------------------------------- </br>';
        $tmp = $this->api_url;
        $thismonth = date('n');
        $thisyear = date('Y');

        $updt_api_url = str_replace(["{year}","{month}"],[$thisyear,$thismonth],$tmp);
        return $updt_api_url;
        //echo $thismonth, $thisyear;
        //echo '<br>--------------------------------------------- </br>';
    }

    //function doesnt't store the data due to database memory not being enough
    // public function getTimetable()
    // {
    //     $timingList = [];
    //     foreach ($this->data->data as $day)
    //     {
    //         $base = $day->date->gregorian;
    //         $date = $base->date;
    //         $weekday = $base->weekday->en;
    //         echo $date;
    //         echo $weekday;
    //         //day contains all the prayer times
    //         //the foreach loop will loop until the end of the month, diplsaying namaz name and time
    //         foreach($day->timings as $title => $time)
    //         {
    //             //condition of removing 2 type of data
    //             if($title !== "Firstthird" && $title !== "Lastthird"){
    //             //may need to clear out firstthird. lastthird
    //             echo $title;
                
    //             echo str_replace(" (UTC)"," ",$time);
    //             //echo $timingList;
    //             }
    //         }
    //     }
    //     //return $timingList; no return required when this instantiate
    // }

    //comparison of dates, will return false or true
    public function datecomp($_data): bool
    {
        $tmp = date("d-m-Y", strtotime($_data));
        $todaydate = date("d-m-Y");
        if($todaydate !== $tmp)
        {
            return TRUE;
        } else { 
            return FALSE; 
        }
    }


    //generates the whole timetable, checks if today's date is same as one of the rows and if so it will highlight
    //removes certain columns that are not required
    public function generateTimetableMonth()
    {
        //$todaydate = date("d-m-Y");
        echo "<div class='table-responsive'>";
        echo "<table border='1', class='table table-striped'>";
        echo "<thead>";
        echo "<tr><th scope='col'>Date</th><th scope='col'>Weekday</th>";
        $first_day = reset($this->data->data);
        $prayer_titles = array_keys((array) $first_day->timings);
        #this might be put as another function instead
        $prayer_titles = array_filter($prayer_titles, function($title)
        {
            return !in_array($title, ["Firstthird","Midnight","Lastthird","Sunrise","Sunset"]);
        });
        
        foreach($prayer_titles as $title){
            echo "<th scope='col'>$title</th>";
        }
        echo "</tr></thead>";
        foreach ($this->data->data as $day)
        {
            $base = $day->date->gregorian;
            $date = $base->date;
            $weekday = $base->weekday->en;
            #echo $tmp;
                       
            if($this->datecomp($date)){
                echo "<tr scope='row'>";
            } else 
            {
                echo '<tr scope="row" class="table-dark">';
            }
            echo "<td>$date</td><td>$weekday</td>";
            foreach ($prayer_titles as $title)
            {
                $time = str_replace( " (UTC)", "",$day->timings->$title);
                echo "<td>$time</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    #data can be fed here so it can take the 
    public function dynamicTimetable()
    {
        echo '
        <div class="timetable-overlap">
        <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="timetable-box bg-light p-4 shadow text-center">
        <h4 class="mb-3">Prayer Timetable</h4>
        <div class="table-responsive">
        <table class="table table-bordered">
        <thead>
        <tr>
        <th>Prayer</th>
        <th>Start</th>
        <th>Jamat</th>
        </tr>
        </thead>
        </tbody>';
        $first_day = reset($this->data->data);
        $prayer_titles = array_keys((array) $first_day->timings);
        #this might be put as another function instead
        $prayer_titles = array_filter($prayer_titles, function($title)
        {
            return !in_array($title, ["Firstthird","Midnight","Lastthird","Sunrise","Sunset"]);
        });
        //comparison of days and if true then show only the prayers of that day
        foreach ($this->data->data as $base){
            
            $_base = $base->date->gregorian;
            $date = $_base->date;
            if(!$this->datecomp($date)){
                echo $date;
                foreach($prayer_titles as $title)
                {
                    echo '<tr>';
                    echo '<td>'.$title.'</td>';
                    $time = str_replace( " (UTC)", "",$base->timings->$title);
                    echo '<td>'.$time.'</td>';
                    echo '</tr>';
                }
                
            }
        }
        echo '</tbody>
        </table>
        </div>
        <small class="text-muted">Times are based on local calculations.</small>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>';
        //$prayer_titles = array_unique((array) $get_data->timings);
        #$prayer_titles = array_filter($prayer_titles, function($title)
        #{
        #    return !in_array($title, ["Firstthird","Midnight","Lastthird","Sunrise","Sunset"]);
        #});
        #foreach($prayer_titles as $title => $name)
        #{
        #    echo $title;
        #    echo $name;
        #}





        echo '</div>';
    }


}

//original url in case it doesn't work anymore
#$api_url = "https://api.aladhan.com/v1/calendar/2025/3?latitude=56.47404281844331&longitude=-2.963501315403592&method=3&shafaq=general&tune=5%2C3%2C5%2C7%2C9%2C-1%2C0%2C8%2C-6&timezonestring=UTC&calendarMethod=UAQ";

//$api_url = "https://api.aladhan.com/v1/calendar/2025/3?latitude=56.47404281844331&longitude=-2.963501315403592&method=3&shafaq=general&tune=5%2C3%2C5%2C7%2C9%2C-1%2C0%2C8%2C-6&timezonestring=UTC&calendarMethod=UAQ";
//$timetable = new PrayerTimeTable();
//$test = $timetable->checkdateandchange();
//$ttbl = $timetable->generateTimetableMonth();

        


        ?>