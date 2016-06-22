<?php

namespace App;

class MyDate {

    public static function get_cur_date() {
        $curr = getdate(time() + 3*60*60);
        $cur_dt = $curr['year'] . '-' . $curr['mon'] . '-' . $curr['mday'] . ' ' . $curr['hours']  . ':' . $curr['minutes'] . ':' . $curr['seconds'];
        $cur_dt = date_create($cur_dt);
        return $cur_dt;
    }


    public static function changeFormat($reviews) {
        foreach ($reviews as $review) {
            $review->date = date_format(date_create($review->created_at), 'd.m.Y');
        }

        return $reviews;
    }

    public static function changeNumbers($date) {
     $curr = getdate(time() + 3*60*60);
     $cur_dt = $curr['year'] . '-' . $curr['mon'] . '-' . $curr['mday'] . ' ' . $curr['hours']  . ':' . $curr['minutes'] . ':' . $curr['seconds'];
     $cur_dt = date_format(date_create($cur_dt), 'd.m');
     $date1 = date_format(date_create($date), 'd.m');
     if($cur_dt == $date1) {
        $date = date_format(date_create($date), 'H:i');
    } else {
        $date = date_format(date_create($date), 'd.m, H:i');
    } 

    return $date;
}


public static function change($date) {
    if($date == '0000-00-00 00:00:00') {
        return 'Не указана';
    }

    $day = date_format(date_create($date), ' d');
    $month = date_format(date_create($date), 'm');
    $time = date_format(date_create($date), 'H:i');
    $year = date_format(date_create($date), 'Y');

    switch (date_format(date_create($date), 'm')) {
        case 1:
        $month = "января";
        break;
        case 2:
        $month = "февраля";
        break;
        case 3:
        $month = "марта";
        break;
        case 4:
        $month = "апреля";
        break;
        case 5:
        $month = "мая";
        break;
        case 6:
        $month = "июня";
        break;
        case 7:
        $month = "июля";
        break;
        case 8:
        $month = "августа";
        break;
        case 9:
        $month = "сентября";
        break;
        case 10:
        $month = "октября";
        break;
        case 11:
        $month = "ноября";
        break;
        case 12:
        $month = "декабря";
        break;
    }
    $date = $day . ' '.$month .' '.$time;
    return $date;
}

public static function historyPageDt($date) {
    if($date != '0000-00-00 00:00:00') {
        $day = date_format(date_create($date), ' d');
        $month = date_format(date_create($date), 'm');
        $time = date_format(date_create($date), 'H:i');
        $year = date_format(date_create($date), 'Y');

        $date =  $day . '.' . $month . '.' . $year;
    } else {
        $date = 'не указана';
    }

    return $date;

}


}
