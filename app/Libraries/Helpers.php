<?php

    function oneTo99Check($number)
    {
        // $number = 1;
        // $number = 101;
        // $number = 99;
        // $number = 199;
        $condition = false;


        $number = $number%100;
        // dd($number);
        if (in_array($number, range(1, 99)))
        {
            $condition=true;
        }

        return $condition;
    }

    function numberFormat($number, $decimals=0)
    {

        // $number = 555;
        // $decimals=0;
        // $number = 555.000;
        // $number = 555.123456;

        if (strpos($number,'.')!=null)
        {
            $decimalNumbers = substr($number, strpos($number,'.'));
            $decimalNumbers = substr($decimalNumbers, 1, $decimals);
        }
        else
        {
            $decimalNumbers = 0;
            for ($i = 2; $i <=$decimals ; $i++)
            {
                $decimalNumbers = $decimalNumbers.'0';
            }
        }
        // return $decimalNumbers;



        $number = (int) $number;
        // reverse
        $number = strrev($number);

        $n = '';
        $stringlength = strlen($number);

        for ($i = 0; $i < $stringlength; $i++)
        {
            if ($i%2==0 && $i!=$stringlength-1 && $i>1)
            {
                $n = $n.$number[$i].',';
            }
            else
            {
                $n = $n.$number[$i];
            }
        }

        $number = $n;
        // reverse
        $number = strrev($number);

        ($decimals!=0)? $number=$number.'.'.$decimalNumbers : $number ;

        return $number;
    }

    function partially_hide_email($email)
    {
        $em   = explode("@",$email);
        $name = implode('@', array_slice($em, 0, count($em)-1));
        // $len  = floor(strlen($name)/2);
        $len  = 5;
        $afterat = end($em);
        $afteratbeforedot = substr($afterat,0,strpos($afterat, '.'));
        $afteratbeforedot2char = substr($afteratbeforedot, -2);
        $afteratafterdot = substr($afterat,strpos($afterat, '.'));

        return substr($name,0, 2) . str_repeat('*', $len) . "@" .str_repeat('*', $len). $afteratbeforedot2char.$afteratafterdot;
    }

    function getLastWord($sentence)
    {
        $pieces = explode(' ', $sentence);
        $last_word = array_pop($pieces);

        return $last_word;
    }


    function setSessionLanguage()
    {
        if ( app()->getLocale() )
        {
            session([app()->getLocale()]);
        }
        else if ( app()->getLocale() )
        {
            session([app()->getLocale()]);
        }
        else
        {
            session(['lang' => 'en']);
        }

    }


    function process_order_number($cartId, $created_at)
    {
        $orderNumber = '#'.$cartId.Carbon\Carbon::parse($created_at)->format('my');
        return $orderNumber;
    }

    function dmyToYmd($date)
    {
        if ($date) {
            $date = substr($date, 6,4).'-'.substr($date, 3,2).'-'.substr($date, 0,2);
            return $date;
        } else {
            return '';
        }
    }

    // carbondatetimeToYmd(\Carbon\Carbon::now('+06:00'))
    function carbondatetimeToYmd($datetime)
    {
        if ($datetime) {
            $date = \Carbon\Carbon::parse($datetime)->format('Y-m-d');
            return $date;
        } else {
            return '';
        }
    }

    // carbondatetimeToDayNumberOfYear('2021-02-12 17:04:05.084512')
    // carbondatetimeToDayNumberOfYear(\Carbon\Carbon::now('+06:00'))
    function carbondatetimeToDayNumberOfYear($datetime)
    {
        if ($datetime) {
            $DayNumberOfYear = \Carbon\Carbon::parse($datetime)->dayOfYear ;
            return $DayNumberOfYear+1;
        } else {
            return '';
        }
    }

    function YmdTodmY($date)
    {
        if ($date) {
            $date = \Carbon\Carbon::parse($date)->format('d-m-Y');
            return $date;
        } else {
            return '';
        }
    }

    function YmdTodmYDay($date)
    {
        if ($date) {
            $date = \Carbon\Carbon::parse($date)->format('d-m-Y  (l)');
            return $date;
        } else {
            return '';
        }
    }

    function YmdTodmYPm($datetime)
    {
        if ($datetime) {
            $date = \Carbon\Carbon::parse($datetime)->format('d-m-Y  g:i A');
            return $date;
        } else {
            return '';
        }
    }

    function YmdTodmYPmgiA($datetime)
    {
        if ($datetime) {
            $date = \Carbon\Carbon::parse($datetime)->format('g:i A');
            return $date;
        } else {
            return '';
        }
    }

    function YmdTodmYPmdMy($datetime)
    {
        if ($datetime) {
            $date = \Carbon\Carbon::parse($datetime)->format('d M, y ');
            return $date;
        } else {
            return '';
        }
    }

    function getCurrentYear(){
        return now()->year;
    }


    function mailformat1($mailReceiverEmail, $mailReceiverName, $mailSenderEmail, $mailSenderName , $subject, $bodyMessage, $website, $contactMails, $numberTitle, $number, $logo, $cartData, $cartdetailsData, $genericpacksizes_with_customer_price_Data, $countryData, $deliverymethodsData)
    {
        $data = array(
            [
                'mailReceiverEmail' => $mailReceiverEmail,
                'mailReceiverName' => $mailReceiverName,
                'mailSenderEmail' => $mailSenderEmail,
                'mailSenderName' => $mailSenderName ,
                'subject' => $subject,
                'bodyMessage' => $bodyMessage,
                'website' => $website,
                'contactMails' => $contactMails,
                'numberTitle' => $numberTitle,
                'number' => $number,
                'logo' => $logo,
                'cartData' => $cartData,
                'cartdetailsData' => $cartdetailsData,
                'genericpacksizes_with_customer_price_Data' => $genericpacksizes_with_customer_price_Data,
                'countryData' => $countryData,
                'deliverymethodsData' => $deliverymethodsData

            ]
        );

        // dd($data);
        // dd($data[0]);
        // dd($data[0]['mailSenderEmail']);



        try{
            Mail::send('mails.mailformat1', $data[0], function ($message)  use ($data) {
                $message->to($data[0]['mailReceiverEmail'], $data[0]['mailReceiverName'])
                        ->bcc($data[0]['mailSenderEmail'])
                        // ->bcc('saifuroracle@gmail.com')
                        ->bcc('medicineforworld@gmail.com')
                        // ->bcc('masudalimran92@gmail.com')
                        // ->bcc('yasir08arafat@yahoo.com')
                        ->bcc('medicineforworld@icloud.com')
                        ->bcc('medicineforworld@yahoo.com')
                        // ->bcc('saifur1193@hotmail.com')
                        // ->bcc('saifurrahman1993@yahoo.com')
                        ->replyTo('info@medicineforworld.com.bd', 'Medicine For World')
                        ->sender('noreply@medicineforworld.com.bd', 'Medicine For World')
                        ->priority(1)
                        ->returnPath('noreply@medicineforworld.com.bd')
                        ->subject($data[0]['subject']);
                $message->from($data[0]['mailSenderEmail'], $data[0]['mailSenderName']);
            });
        }
        catch (Exception $e) {
            DB::table('errors')->insert([
                'error' => 'Mail Sending Error - Order related -'.$e->getMessage()
            ]);
        }

    }


    function priceinquiremailformat($mailReceiverEmail, $mailReceiverName, $mailSenderEmail, $mailSenderName , $subject, $bodyMessage, $website, $contactMails, $numberTitle, $number, $logo, $cgenericName, $cgenericCompany, $cdosageForm, $cgenericPackSize, $cprescription, $cgenericStrength, $cpackType, $cmessage, $cgenericBrandName, $cgenericBrandId, $cinquirerId ,$cname, $cmail )
    {
        $data = array(
            [
                'mailReceiverEmail' => $mailReceiverEmail,
                'mailReceiverName' => $mailReceiverName,
                'mailSenderEmail' => $mailSenderEmail,
                'mailSenderName' => $mailSenderName ,
                'subject' => $subject,
                'bodyMessage' => $bodyMessage,
                'website' => $website,
                'contactMails' => $contactMails,
                'numberTitle' => $numberTitle,
                'number' => $number,
                'logo' => $logo,
                'cgenericName' => $cgenericName,
                'cgenericCompany' => $cgenericCompany,
                'cdosageForm' => $cdosageForm,
                'cgenericPackSize' => $cgenericPackSize,
                'cprescription' => $cprescription,
                'cgenericStrength' => $cgenericStrength,
                'cpackType' => $cpackType,
                'cmessage' => $cmessage,
                'cgenericBrandName' => $cgenericBrandName,
                'cgenericBrandId' => $cgenericBrandId,
                'cinquirerId' => $cinquirerId,
                'cname' => $cname,
                'cmail' => $cmail,

            ]
        );

        // dd($data);
        // dd($data[0]);
        // dd($data[0]['mailSenderEmail']);



        try{
            Mail::send('mails.priceinquiry', $data[0], function ($message)  use ($data) {
                $message->to($data[0]['mailReceiverEmail'], $data[0]['mailReceiverName'])
                        ->bcc($data[0]['mailSenderEmail'])
                        // ->bcc('saifuroracle@gmail.com')
                        ->bcc('medicineforworld@gmail.com')
                        // ->bcc('masudalimran92@gmail.com')
                        ->bcc('medicineforworld@icloud.com')
                        ->bcc('medicineforworld@yahoo.com')
                        // ->bcc('saifur1193@hotmail.com')
                        // ->bcc('saifurrahman1993@yahoo.com')
                        ->replyTo('info@medicineforworld.com.bd', 'Medicine For World')
                        ->sender('noreply@medicineforworld.com.bd', 'Medicine For World')
                        ->priority(1)
                        ->returnPath('noreply@medicineforworld.com.bd')
                        ->subject($data[0]['subject']);
                $message->from($data[0]['mailSenderEmail'], $data[0]['mailSenderName']);
            });
        }
        catch (Exception $e) {
            DB::table('errors')->insert([
                'error' => 'Mail Sending Error -Price inquiry- '.$e->getMessage()
            ]);
        }

    }




    function mailformat2($mailReceiverEmail, $mailReceiverName, $mailSenderEmail, $mailSenderName , $subject, $bodyMessage, $website, $contactMails, $numberTitle, $number, $logo)
    {
        $data = array(
            [
                'mailReceiverEmail' => $mailReceiverEmail,
                'mailReceiverName' => $mailReceiverName,
                'mailSenderEmail' => $mailSenderEmail,
                'mailSenderName' => $mailSenderName ,
                'subject' => $subject,
                'bodyMessage' => $bodyMessage,
                'website' => $website,
                'contactMails' => $contactMails,
                'numberTitle' => $numberTitle,
                'number' => $number,
                'logo' => $logo,
            ]
        );

        // dd($data);
        // dd((object)($data[0]));

        $data = (object)($data[0]);

        try{
            Mail::send('mails.mailformat2', (array) $data, function ($message)  use ($data) {
                $message->to($data->mailReceiverEmail, $data->mailReceiverName)
                        // ->bcc($data->mailSenderEmail)
                        // ->replyTo($data->mailSenderEmail,  $data->mailSenderName)
                        ->sender($data->mailSenderEmail,  $data->mailSenderName)
                        // ->priority(1)
                        // ->returnPath($data->['mailSenderEmail'])
                        // ->subject('This is last week rev report!');
                        ->subject($data->subject);
                        $message->from($data->mailSenderEmail,  $data->mailSenderName);
                });

        }
        catch (Exception $e) {
            // dd($e->getMessage());
            return App\Traits\ApiResponser::set_response(null, 400, 'error', $e->getMessage());
        }
    }

    function mailformat2_1($mailReceiverEmail, $mailReceiverName, $mailSenderEmail, $mailSenderName , $subject, $bodyMessage, $website, $contactMails, $numberTitle, $number, $logo)
    {
        $data = array(
            [
                'mailReceiverEmail' => $mailReceiverEmail,
                'mailReceiverName' => $mailReceiverName,
                'mailSenderEmail' => $mailSenderEmail,
                'mailSenderName' => $mailSenderName ,
                'subject' => $subject,
                'bodyMessage' => $bodyMessage,
                'website' => $website,
                'contactMails' => $contactMails,
                'numberTitle' => $numberTitle,
                'number' => $number,
                'logo' => $logo,
            ]
        );

        // dd($data);
        // dd($data[0]);
        // dd($data[0]['mailSenderEmail']);



        try{
            Mail::send('mails.mailformat2', $data[0], function ($message)  use ($data) {
                $message->to('medicineforworld@gmail.com', $data[0]['mailReceiverName'])
                        ->bcc($data[0]['mailSenderEmail'])
                        // ->bcc('saifuroracle@gmail.com')
                        // ->bcc('masudalimran92@gmail.com')
                        ->bcc('medicineforworld@icloud.com')
                        ->bcc('medicineforworld@yahoo.com')
                        // ->bcc('saifur1193@hotmail.com')
                        // ->bcc('saifurrahman1993@yahoo.com')
                        ->replyTo('info@medicineforworld.com.bd', 'Medicine For World')
                        ->sender('noreply@medicineforworld.com.bd', 'Medicine For World')
                        ->priority(1)
                        ->returnPath('noreply@medicineforworld.com.bd')
                        ->subject($data[0]['subject']);
                $message->from($data[0]['mailSenderEmail'], $data[0]['mailSenderName']);
            });
        }
        catch (Exception $e) {
            DB::table('errors')->insert([
                'error' => 'Mail Sending Error - Order related -'.$e->getMessage()
            ]);
        }

    }



    function mailformat2_2($mailReceiverEmail, $mailReceiverName, $mailSenderEmail, $mailSenderName , $subject, $bodyMessage, $website, $contactMails, $numberTitle, $number, $logo)
    {
        $data = array(
            [
                'mailReceiverEmail' => $mailReceiverEmail,
                'mailReceiverName' => $mailReceiverName,
                'mailSenderEmail' => $mailSenderEmail,
                'mailSenderName' => $mailSenderName ,
                'subject' => $subject,
                'bodyMessage' => $bodyMessage,
                'website' => $website,
                'contactMails' => $contactMails,
                'numberTitle' => $numberTitle,
                'number' => $number,
                'logo' => $logo,
            ]
        );


        Mail::send('mails.mailformat2', $data[0], function ($message)  use ($data) {
            $message->to($data[0]['mailReceiverEmail'], $data[0]['mailReceiverName'])
                    ->bcc('medicineforworld@gmail.com')
                    ->bcc('medicineforworld@icloud.com')
                    ->bcc('medicineforworld@yahoo.com')
                    // ->bcc('masudalimran92@gmail.com')
                    ->replyTo('info@medicineforworld.com.bd', 'Medicine For World')
                    ->sender('noreply@medicineforworld.com.bd', 'Medicine For World')
                    ->priority(1)
                    ->returnPath('noreply@medicineforworld.com.bd')
                    ->subject($data[0]['subject']);
            $message->from($data[0]['mailSenderEmail'], $data[0]['mailSenderName']);
        });


    }


    function emailreplace($email){

        $email = str_replace('@','[at]' , $email);
        $email = str_replace('.','[dot]' , $email);
        return $email;
    }

    function strip_except_english($str){

        // $str = preg_replace('/[^0-9A-Za-z\-]/', '', $str);
        $str = preg_replace('/\p{Han}+/u', '', $str);  // strip chinese
        $str = preg_replace('/[\x{0410}-\x{042F}]+.*[\x{0410}-\x{042F}]+/iu', '', $str);  // strip russian
        return $str;
    }

    function cacheRemove()
    {
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('config:cache');
        } catch (\Throwable $th) {
        }
    }


    function getLocaleFromUrl($url)
    {
        $baseUrl = url('/');

        if(strpos($url,$baseUrl.'/en') !== false || (strpos($url,$baseUrl.'/en/cn') !== false)  || (strpos($url,$baseUrl.'/en/ru') !== false))
        {
            return 'en';
        }
        elseif(strpos($url,$baseUrl.'/cn') !== false || (strpos($url,$baseUrl.'/cn/en') !== false)  || (strpos($url,$baseUrl.'/cn/ru') !== false))
        {
            return 'cn';
        }
        elseif(strpos($url,$baseUrl.'/ru') !== false || (strpos($url,$baseUrl.'/ru/en') !== false)  || (strpos($url,$baseUrl.'/ru/cn') !== false))
        {
            return 'ru';
        }
        else{
            return 'en';
        }
    }


    // algorithms

    // prime numbers
    function isPrime($n)
    {
        // Corner case
        if ($n <= 1)
            return false;

        // Check from 2 to n-1
        for ($i = 2; $i < $n; $i++)
            if ($n % $i == 0)
                return false;

        return true;
    }


    function getToday()
    {
        return date('Y-m-d');
    }
    function getTodayWStartTime()
    {
        return date('Y-m-d').' 00:00:00';
    }
    function getTodayWEndTime()
    {
        return date('Y-m-d').' 23:59:59';
    }
    function getThisWeekFirstDay()
    {
        return \Carbon\Carbon::now('+06:00')->subDays(6)->format('Y-m-d');
    }
    function getThisWeekFirstDayWStartTime()
    {
        return \Carbon\Carbon::now('+06:00')->subDays(6)->format('Y-m-d').' 00:00:00';
    }

    function getThisMonthFirstDay()
    {
        return \Carbon\Carbon::now('+06:00')->subDays(30)->format('Y-m-d');
    }
    function getThisMonthFirstDayWStartTime()
    {
        return \Carbon\Carbon::now('+06:00')->subDays(30)->format('Y-m-d').' 00:00:00';
    }



    function getTodayDateTime()
    {
        return date('Y-m-d H:i:s');
    }

    function getNow()
    {
        return \Carbon\Carbon::now('+06:00');
    }

    function getYesterday()
    {
        return \Carbon\Carbon::yesterday()->format('Y-m-d');
    }

    function getYesterdayWStartTime()
    {
        return \Carbon\Carbon::yesterday()->format('Y-m-d').' 00:00:00';
    }

    function getYesterdayWEndTime()
    {
        return \Carbon\Carbon::yesterday()->format('Y-m-d').' 23:59:59';
    }



    function getLast30DaysFirstDayExceptToday()
    {
        return \Carbon\Carbon::now('+06:00')->subDays(30)->format('Y-m-d');
    }

    function getLastNDaysFirstDayExceptToday($days)
    {
        return \Carbon\Carbon::now('+06:00')->subDays($days)->format('Y-m-d');
    }


    function getDatesFromARange($firstDay, $numberofdays)
    {
        $dates = [];
        $currentDate = $firstDay;
        for ($i=0; $i < $numberofdays ; $i++)
        {
            $dates[$i] = $currentDate;
            $currentDate = date('Y-m-d', strtotime("+1 day", strtotime($dates[$i])));
        }
        return $dates;
    }

    function getAddDaysToDatetimeN($datetime, $daynumber)
    {
        return date('Y-m-d H:i:s', strtotime("+".$daynumber." day", strtotime($datetime)));
    }


    function getDatesDMYFromARange($firstDay, $numberofdays)
    {
        $dates = [];
        $currentDate = $firstDay;
        for ($i=0; $i < $numberofdays ; $i++)
        {
            $dates[$i] = YmdTodmY($currentDate);
            $currentDate = date('Y-m-d', strtotime("+1 day", strtotime($dates[$i])));
        }
        return $dates;
    }

    function getDatesFrom2Dates($date1, $date2)
    {
        $dates = [];
        if ($date2 > $date1)
        {
            $numberofdays = getNumberOfDaysFrom2Dates($date1, $date2)+1;
            $dates = getDatesFromARange($date1, $numberofdays);
        }
        return $dates;
    }

    function getNumberOfDaysFrom2Dates($fdate, $tdate)
    {
        $datetime1 = strtotime($fdate); // convert to timestamps
        $datetime2 = strtotime($tdate); // convert to timestamps
        $days = (int)(($datetime2 - $datetime1)/86400); // will give the difference in days , 86400 is the timestamp difference of a day
        return $days;
    }





    function array_flatten($array) {
        if (!is_array($array)) {
            return false;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, array_flatten($value));
            } else {
                $result = array_merge($result, array($key => $value));
            }
        }
        return $result;
    }

    function getDayIdWithDayFullName($day)
    {
        $day = strtolower($day);
        $dayId = 0;
        switch ($day) {
            case 'saturday':
                $dayId=1;
                break;
            case 'sunday':
                $dayId=2;
                break;
            case 'monday':
                $dayId=3;
                break;
            case 'tuesday':
                $dayId=4;
                break;
            case 'wednesday':
                $dayId=5;
                break;
            case 'thursday':
                $dayId=6;
                break;
            case 'friday':
                $dayId=7;
                break;
            default:
                $dayId=0;
        }

        return $dayId;
    }

    function getStatusString($status=0)
    {
        $statusstring = 'Inactive';
        if ($status==1) {
            $statusstring = 'Active';
        }
        return $statusstring;
    }


    // paginate
    // paginate

    function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Illuminate\Support\Collection ? $items : Illuminate\Support\Collection::make($items);

        $data = new Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage)->values(), $items->count(), $perPage, $page, $options);

        return $data;
    }

    function getFormattedPaginatedArray($data)
    {
        return (object) [
            'current_page' => $data->currentPage(),
            'total_pages' => $data->lastPage(),
            'previous_page_url' => $data->previousPageUrl(),
            'next_page_url' => $data->nextPageUrl(),
            'record_per_page' => $data->perPage(),
            'current_page_items_count' => $data->count(),
            'total_count' => $data->total(),
            'pagination_last_page' => $data->lastPage(),
        ];
    }


    // base 64 file related
    // base 64 file related
    // base 64 file related

    function getBase64FileExtension($base64_string)
    {
        $extension = explode('/', mime_content_type($base64_string))[1];
        return $extension;
    }

    function getBase64FileSize($base64_string)
    {
        $size = (int) (strlen(rtrim($base64_string, '=')) * 3 / 4);
        return $size/1024;
    }

    function getBase64FileSize_W_KB_MB($base64_string)
    {
        $size = (int) (strlen(rtrim($base64_string, '=')) * 3 / 4);

        $size = $size/1024; // in kb now

        if ( $size >= 1024 )
        {
            $size= ((int) ($size/1024)).' MB';
        }
        else{
            $size= $size.' KB';
        }

        return $size;
    }

    function base64_file_type_validation($base64_file_string='', $file_types_array=[])
    {
        if (strlen($base64_file_string)>100)
        {
            $extension = getBase64FileExtension($base64_file_string);
            if (!in_array($extension, $file_types_array))
            {
                return [0, 'Available file format '.implode(", ",$file_types_array)];
            }
            else{
                return [1, null];
            }
        }
        return [0, 'Invalid file string'];
    }

    function base64_file_size_validation($base64_file_string='', $max_file_size=[])
    {
        if (strlen($base64_file_string)>100)
        {
            $size = getBase64FileSize($base64_file_string);
            if ($size>$max_file_size)
            {
                return [0, 'Max file size '.$max_file_size.' KB exceeded!'];
            }
            else
            {
                return [1, null];
            }
        }
        return [0, 'Invalid file string'];
    }


    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = (strpos($string, $end, $ini) - $ini)<0 ? strlen($string) : 0;
        // dd($len);
        return substr($string, $ini, $len);
    }

    function compareData($newData=0, $oldData=1)
    {
        if ($oldData==0) {
            return 0;
        }
        return ($newData*100)/$oldData;
    }


    function getPaginatedSerial($paginator, $index)
    {
        return $paginator->current_page>1 ? (($paginator->current_page-1) * $paginator->record_per_page+$index+1) :  $index+1 ;
    }
?>
