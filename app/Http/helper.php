<?php

use Illuminate\Support\Facades\Mail;

if (!function_exists('sendEmail')) {
    function sendEmail($to_email, $ccemail, $subject, $template, $data)
    {
        Mail::send($template, ['data' => $data], function ($message) use ($subject, $to_email, $ccemail) {
            $message->to($to_email, $subject)->subject($subject)
                ->bcc($ccemail, $subject)->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS'), $subject);

        });
    }
}

if (!function_exists('send_email')) {
    function send_email($to_email, $subject, $template, $data)
    {
        Mail::send($template, ['emailinfo' => $data], function ($message) use ($subject, $to_email) {
            $message->to($to_email, $subject)->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS'), $subject);
        });
    }
}
if (!function_exists('send_email_test')) {
    function send_email_test($to_email, $subject, $template, $data)
    {
        Mail::send($template, ['emailinfo' => $data], function ($message) use ($subject, $to_email) {
            $message->to($to_email, $subject)->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS'), $subject);
        });
    }
}
if (!function_exists('format_date')) {
    function format_date($date)
    {
        if (empty($date) or $date == '0000-00-00' or $date == null or $date == '1899-12-30' or $date == '01-01-1970') {
            return '';
        } else if ($date == '-' or $date == '--') {
            return $date;
        } else {
            $timestamp = strtotime($date);
            return date('m-d-Y', $timestamp);
        }
    }
}
if (!function_exists('db_format_date')) {
    function db_format_date($date)
    {
        if (empty($date)) {
            return null;
        } else {
            $timestamp = strtotime($date);
            return date('Y-m-d', $timestamp);
        }
    }
}
if (!function_exists('numberformat')) {
    function numberformat($number)
    {
        return number_format((float) $number, 2, '.', '');
    }
}
if (!function_exists('db_format_date_month')) {
    function db_format_date_month($date)
    {
        if (empty($date)) {
            return null;
        } else {
            $date = explode('-', $date);
            $date = $date[2] . '-' . $date[0] . '-' . $date[1];
            return $date;
        }
    }
}
if (!function_exists('db_format_date_slash')) {
    function db_format_date_slash($date)
    {
        if (empty($date)) {
            return null;
        } else {
            $date = explode('/', $date);
            $date = $date[2] . '-' . $date[1] . '-' . $date[0];
            return $date;
        }
    }
}
function get_settings($column)
{
    $data = \App\Models\Setting\Settings::select($column)->first();
    $data = $data->$column;
    return $data;
}
function get_business()
{
    $data = \App\Models\User::where('role_id', 3)->take(9)->get();
    $data = $data;
    return $data;
}
function get_membership()
{
    $data = \App\Models\Memberships\Membership::get();
    $data = $data;
    return $data;
}
function get_availability($total_tickets, $product_id)
{
    $data = \App\Models\Reservations\Reservation::where('product_id', $product_id)->sum('people');
    $data = $total_tickets - $data;
    return $data;
}
function get_availability_tickets($total_tickets, $product_id)
{
    $data = \App\Models\Reservations\Reservation::where('product_id', $product_id)->sum('total_tickets');
    $data = $total_tickets - $data;
    return $data;
}
/*
 *@parameters: Datetime, full time
 *@returns: time string
 *@description: this function returns full Date time (including weeks and days)
 */
if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = true)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
/*
 *@parameters: orignal string, string to intersect
 *@returns: resulting string
 *@description: this function returns subtract string after the intersected string occurance
 */
if (!function_exists('strafter')) {
    function strafter($string, $substring)
    {
        $pos = strpos($string, $substring);
        if ($pos === false) {
            return $string;
        } else {
            return (substr($string, $pos + strlen($substring)));
        }

    }
}
/*
 *@parameters: orignal string, string to subtract
 *@returns: resulting string
 *@description: this function returns subtract string before the intersected string occurance
 */
if (!function_exists('strbefore')) {
    function strbefore($string, $substring)
    {
        $pos = strpos($string, $substring);
        if ($pos === false) {
            return $string;
        } else {
            return (substr($string, 0, $pos));
        }

    }
}
if (!function_exists('week_days')) {
    function week_days()
    {
        $arrayday = array(
            'Monday' => 'Monday',
            'Tuesday' => 'Tuesday',
            'Wednesday' => 'Wednesday',
            'Thursday' => 'Thursday',
            'Friday' => 'Friday',
            'Saturday' => 'Saturday',
            'Sunday' => 'Sunday',
        );
        return $arrayday;
    }
}

if (!function_exists('attachment_types')) {
    function attachment_types()
    {
        $data = array(
            'Personal Information' => 'Personal Information',
            'Dispute Letters' => 'Dispute Letters',
            'Credit Repair Agreement' => 'Credit Repair Agreement',
        );
        return $data;
    }
}
if (!function_exists('credit_types')) {
    function credit_types()
    {
        $data = array(
            'Credit Scores' => 'Credit Scores',
            'Negative Items' => 'Negative Items',
            'Items In Dispute' => 'Items In Dispute',
            'Deleted Items' => 'Deleted Items',
        );
        return $data;
    }
}

// function get_notification(){
//       $notification=\App\Models\Training\TrainingResource::whereDate('created_at',DB::raw('CURDATE()'))->get();
//        return $notification;
//     }
if (!function_exists('deal_items')) {
    function deal_items()
    {
        $data = array(
            0 => 'Advance Rent',
            1 => 'Security Deposit',
            2 => 'Other',
        );
        return $data;
    }
}
if (!function_exists('payment_modes')) {
    function payment_modes()
    {
        $data = array(
            'Cash' => 'Cash',
            'Mortgaged' => 'Mortgaged',
            'Debit Card' => 'Debit Card',
            'Credit Card' => 'Credit Card',
            'BACS' => 'BACS',
            'Cheque' => 'Cheque',
            'Cash & Card' => 'Cash & Card',
            'Cash & BACS' => 'Cash & BACS',
            'Cash & Cheque' => 'Cash & Cheque',
            'Other' => 'Other',
        );
        return $data;
    }
}

if (!function_exists('personalites')) {
    function personalites()
    {
        $data = array(
            1 => 'teacher',
            2 => 'helper',
            3 => 'performer',
            4 => 'romantic',
            5 => 'investigator',
            6 => 'loyalist',
            7 => 'enthusiast',
            8 => 'challenger',
            9 => 'peacemaker',
        );
        return $data;
    }
}

if (!function_exists('check_attachment')) {
    function check_attachment($type, $customer_id)
    {
        $data = \App\Models\Customer\Attachment::where('type', $type)->where('customer_id', $customer_id)->first();
        return $data;
    }
}
if (!function_exists('get_personality')) {
    function get_personality($id)
    {
        $data = \App\Models\Test\Personality::where('id', $id)->first();
        if ($data) {
            return $data->name;
        }
        return '';
    }
}
if (!function_exists('check_reverse')) {
    function check_reverse($is_reverse, $answer)
    {
        if ($is_reverse == 1) {
            if ($answer == 0) {
                $result = 3;
            } elseif ($answer == 1) {
                $result = 2;
            } elseif ($answer == 2) {
                $result = 1;
            } elseif ($answer == 3) {
                $result = 0;
            }
        } else {
            $result = $answer;
        }
        return $result;
    }
}
if (!function_exists('check_credit')) {
    function check_credit($type, $customer_id)
    {
        $data = \App\Models\Customer\Credit::where('type', $type)
            ->where('customer_id', $customer_id)->orderBy('id', 'desc')->first();
        return $data;
    }
}
if (!function_exists('check_itemlist')) {
    function check_itemlist($item_id, $lead_id)
    {
        $data = \App\Models\Property\Checklist::where('item_id', $item_id)->where('lead_id', $lead_id)->first();
        return $data;
    }
}
if (!function_exists('set_multi_uploads')) {
    function set_multi_uploads($old, $new)
    {
        $old_uploads = array();
        $new_uploads = array();
        if (json_decode($old)) {
            $old_uploads = json_decode($old);
        }
        if (json_decode($new)) {
            $new_uploads = json_decode($new);
        }

        $uploads = json_encode(array_merge($old_uploads, $new_uploads));
        $final_uploads = array();
        foreach (json_decode($uploads) as $row) {
            $row = trim($row);

            if (file_exists(ltrim($row, '/'))) {
                $final_uploads[] = $row;
            }

        }
        return json_encode($final_uploads);
    }
}

if (!function_exists('set_json_encode')) {
    function set_json_encode($data)
    {
        $encodeddata = $data != null ? json_encode($data) : json_encode(array());
        return $encodeddata;
    }
}

if (!function_exists('set_message')) {
    function set_message($affected_rows, $module, $action)
    {
        if ($affected_rows) {
            $message['title'] = 'Success';
            $message['text'] = $module . " Information " . $action . " Successfully";
        } else {
            $message['title'] = 'Error';
            $message['text'] = "Something went wrong";
        }
        return $message;
    }
}
if (!function_exists('userdp')) {
    function userdp($avatar)
    {
        if (File::exists(public_path() . '/uploads/users/dp/' . $avatar) && $avatar) {
            $dp = url('/') . '/public/uploads/users/dp/' . $avatar;
        } else {
            $dp = url('public/uploads/users/dp/user4.jpg');
        }
        return $dp;
    }
}
if (!function_exists('time_ago')) {
    function time_ago($datetime, $full = false)
    {

        $now = new \DateTime();
        $ago = new \DateTime($datetime);

        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
if (!function_exists('create_log')) {
    function create_log($type, $detail)
    {
        $data = array(
            'user_id' => Auth::user()->user_id,
            'type' => $type,
            'detail' => $detail,
        );
        App\Models\Log::create($data);
    }
}
if (!function_exists('edit_link')) {
    function edit_link($link)
    {
        $data = '<a href="' . $link . '" class="btn btn-outline-warning m-btn m-btn--icon m-btn--icon-only m-btn--outline-1x m-btn--pill m-btn--air btn-edit"
      data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="Edit">
                   <i class="fa fa-pencil-alt"></i>
                </a>';
        return $data;
    }
}
if (!function_exists('delete_link')) {
    function delete_link($link)
    {
        $data = '<a  data-href="' . $link . '" data-toggle="modal" data-target="#confirm-delete"  href="#" class="btn btn-outline-accent m-btn m-btn--icon m-btn--icon-only m-btn--outline-1x m-btn--pill m-btn--air"
      data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="Delete">
                   <i class="fa fa-trash-alt"></i>
                </a>';
        return $data;
    }
}
if (!function_exists('detail_link')) {
    function detail_link($link)
    {
        $data = '<a href="' . $link . '" class="btn btn-outline-warning m-btn m-btn--icon m-btn--icon-only m-btn--outline-1x m-btn--pill m-btn--air btn-edit"
      data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="Detail">
                   <i class="fa fa-list"></i>
                </a>';
        return $data;
    }
}
if (!function_exists('show_button')) {
    function show_button($link, $title)
    {
        $data = '<a href="' . $link . '" class="btn btn-outline-success btn-add">' . $title . ' </a>';
        return $data;
    }
}
if (!function_exists('show_smbutton')) {
    function show_smbutton($link, $title)
    {
        $data = '<a href="' . $link . '" class="btn btn-sm btn-outline-success btn-add">' . $title . ' </a>';
        return $data;
    }
}
if (!function_exists('status_text')) {
    function status_text($status)
    {
        if ($status == 1) {
            return 'Active';
        }
        return 'Inactive';
    }
}
if (!function_exists('client_status')) {
    function client_status($contracts)
    {

        if (!empty($contracts)) {
            $count = count($contracts) - 1;
            if (strtotime($contracts[$count]->end_date) < strtotime(date('Y-m-d'))) {
                return 'Inactive';
            }
//                dd($contracts[$count]->end_date);
        }
        return 'Active';
    }
}
if (!function_exists('expiry_rem_period')) {
    function expiry_rem_period($date, $label)
    {
        $remaining_period = "";
//        echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";
//        echo $interval->format('%y years %m months and %d days');
        if (!empty($date)) {
            if (strtotime(date('Y-m-d')) > strtotime($date)) {
                $remaining_period .= '<div class="expiry label-danger">' . $label . ' Has Been Expired</div>';
            }
            $datetime1 = new DateTime(date('Y-m-d'));
            $datetime2 = new DateTime($date);
            $interval = $datetime1->diff($datetime2);

            if ($interval->y > 0) {
                $remaining_period .= '<div class="expiry">' . $interval->y . ' Year,' . $interval->m . ' Months, ' . $interval->d . ' Days Remaining In The Expiry Of ' . $label . '</div>';
            } else if ($interval->y == 0 && $interval->m > 0 && $interval->d > 0) {
                $remaining_period .= '<div class="expiry">' . $interval->m . ' Months,' . $interval->d . ' Days Remaining In The Expiry Of ' . $label . '</div>';
            } else {
                $remaining_period .= '<div class="expiry">' . $interval->d . ' Days Remaining In The Expiry Of ' . $label . '</div>';
            }
        }
//        dd($remaining_period);

        return $remaining_period;
    }
}
if (!function_exists('show_attachements')) {
    function show_attachements($data)
    {
        $attachment = '<div class="mt-2">No Attachment Avaiable</div>';
        if (!empty(trim($data, "[]"))) {
            $attachment = "";
            foreach (json_decode($data) as $key => $value) {
                $attachment .= '<div class="col-md-12 file_div">';
                if (file_exists($value)) {
                    $path = url('/') . '/' . $value;
                    $name = strafter($value, '-');
                    $attachment .= ' <div class="mt-2">
                                <a href="' . $path . '"><i class="flaticon-file"></i>' . $name . '</a> </div>  </div>';
                }
            }
        }
        return $attachment;
    }
}
if (!function_exists('show_pics')) {
    function show_pics($data)
    {
        $attachment = '<div class="mt-2">No Attachment Avaiable</div>';
        if (!empty(trim($data, "[]"))) {
            $attachment = "";
            $attachment .= '<div class="row">';
            foreach (json_decode($data) as $key => $value) {
                $attachment .= '<div class="col-md-3">';
                if (file_exists($value)) {
                    $path = url('/') . '/' . $value;
                    $name = strafter($value, '-');
                    $attachment .= ' <div class="mt-2">
                                <a href="' . $path . '">
                                <img class="img_frame" width="200" height="150" src="' . $path . '" alt="">' . '</a> </div>
                                </div>';
                }
            }
            $attachment .= '</div>';
        }
        return $attachment;
    }
}
if (!function_exists('multi_json_values')) {
    function multi_json_values($data)
    {
        $text = "";
        if (!empty(trim($data, "[]"))) {
            foreach (json_decode($data) as $key => $value) {
                if ($key > 0) {
                    $text .= ',';
                }
                $text .= $value;
            }
        }

        return $text;
    }
}
if (!function_exists('createDateRangeArray')) {
    function createDateRangeArray($strDateFrom, $strDateTo)
    {
        $aryRange = array();
        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('d-m-Y', $iDateFrom)); // first entry
            while ($iDateFrom < $iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('d-m-Y', $iDateFrom));
            }
        }
        return $aryRange;
    }
}

if (!function_exists('hours_diff')) {
    function hours_diff($total, $actual)
    {
        if ($actual > $total) {
            $diff = $actual - $total;
            $diff = '+' . $diff;
        } else {
            $diff = $total - $actual;
            $diff = '-' . $diff;
        }
        return $diff;
    }
}

if (!function_exists('get_countries')) {
    function get_countries()
    {
        $countries = array
            (
            'AT' => 'Austria',
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua And Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia And Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'CA' => 'Canada',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Congo, Democratic Republic',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote D\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DJ' => 'Djibouti',
            'DK' => 'Denmark',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands (Malvinas)',
            'FO' => 'Faroe Islands',
            'FR' => 'France',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'DE' => 'Germany',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island & Mcdonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran, Islamic Republic Of',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle Of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Lao People\'s Democratic Republic',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia, Federated States Of',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'AN' => 'Netherlands Antilles',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NL' => 'Netherlands',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory, Occupied',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts And Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre And Miquelon',
            'VC' => 'Saint Vincent And Grenadines',
            'WS' => 'Samoa',
            'CH' => 'Switzerland',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome And Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia And Sandwich Isl.',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard And Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad And Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks And Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Viet Nam',
            'VG' => 'Virgin Islands, British',
            'VI' => 'Virgin Islands, U.S.',
            'WF' => 'Wallis And Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        );
        return $countries;
    }
}
if (!function_exists('counties')) {
    function counties()
    {
        $data = array(
            'Avon',
            'Bedfordshire',
            'Berkshire',
            'Buckinghamshire',
            'Cambridgeshire',
            'Cheshire',
            'Cleveland',
            'Cornwall',
            'Cumbria',
            'Derbyshire',
            'Devon',
            'Dorset',
            'Durham',
            'East Sussex',
            'Essex',
            'Gloucestershire',
            'Hampshire',
            'Herefordshire',
            'Hertfordshire',
            'Isle of Wight',
            'Kent',
            'Lancashire',
            'Leicestershire',
            'Lincolnshire',
            'London',
            'Merseyside',
            'Middlesex',
            'Norfolk',
            'Northamptonshire',
            'Northumberland',
            'North Humberside',
            'North Yorkshire',
            'Nottinghamshire',
            'Oxfordshire',
            'Rutland',
            'Shropshire',
            'Somerset',
            'South Humberside',
            'South Yorkshire',
            'Staffordshire',
            'Suffolk',
            'Surrey',
            'Tyne and Wear',
            'Warwickshire',
            'West Midlands',
            'West Sussex',
            'West Yorkshire',
            'Wiltshire',
            'Worcestershire',
        );
        return $data;
    }
}

if (!function_exists('languages')) {
    function languages()
    {
        $language_codes = array(
            'en' => 'English',
            'aa' => 'Afar',
            'ab' => 'Abkhazian',
            'af' => 'Afrikaans',
            'am' => 'Amharic',
            'ar' => 'Arabic',
            'as' => 'Assamese',
            'ay' => 'Aymara',
            'az' => 'Azerbaijani',
            'ba' => 'Bashkir',
            'be' => 'Byelorussian',
            'bg' => 'Bulgarian',
            'bh' => 'Bihari',
            'bi' => 'Bislama',
            'bn' => 'Bengali/Bangla',
            'bo' => 'Tibetan',
            'br' => 'Breton',
            'ca' => 'Catalan',
            'co' => 'Corsican',
            'cs' => 'Czech',
            'cy' => 'Welsh',
            'da' => 'Danish',
            'de' => 'German',
            'dz' => 'Bhutani',
            'el' => 'Greek',
            'eo' => 'Esperanto',
            'es' => 'Spanish',
            'et' => 'Estonian',
            'eu' => 'Basque',
            'fa' => 'Persian',
            'fi' => 'Finnish',
            'fj' => 'Fiji',
            'fo' => 'Faeroese',
            'fr' => 'French',
            'fy' => 'Frisian',
            'ga' => 'Irish',
            'gd' => 'Scots/Gaelic',
            'gl' => 'Galician',
            'gn' => 'Guarani',
            'gu' => 'Gujarati',
            'ha' => 'Hausa',
            'hi' => 'Hindi',
            'hr' => 'Croatian',
            'hu' => 'Hungarian',
            'hy' => 'Armenian',
            'ia' => 'Interlingua',
            'ie' => 'Interlingue',
            'ik' => 'Inupiak',
            'in' => 'Indonesian',
            'is' => 'Icelandic',
            'it' => 'Italian',
            'iw' => 'Hebrew',
            'ja' => 'Japanese',
            'ji' => 'Yiddish',
            'jw' => 'Javanese',
            'ka' => 'Georgian',
            'kk' => 'Kazakh',
            'kl' => 'Greenlandic',
            'km' => 'Cambodian',
            'kn' => 'Kannada',
            'ko' => 'Korean',
            'ks' => 'Kashmiri',
            'ku' => 'Kurdish',
            'ky' => 'Kirghiz',
            'la' => 'Latin',
            'ln' => 'Lingala',
            'lo' => 'Laothian',
            'lt' => 'Lithuanian',
            'lv' => 'Latvian/Lettish',
            'mg' => 'Malagasy',
            'mi' => 'Maori',
            'mk' => 'Macedonian',
            'ml' => 'Malayalam',
            'mn' => 'Mongolian',
            'mo' => 'Moldavian',
            'mr' => 'Marathi',
            'ms' => 'Malay',
            'mt' => 'Maltese',
            'my' => 'Burmese',
            'na' => 'Nauru',
            'ne' => 'Nepali',
            'nl' => 'Dutch',
            'no' => 'Norwegian',
            'oc' => 'Occitan',
            'om' => '(Afan)/Oromoor/Oriya',
            'pa' => 'Punjabi',
            'pl' => 'Polish',
            'ps' => 'Pashto/Pushto',
            'pt' => 'Portuguese',
            'qu' => 'Quechua',
            'rm' => 'Rhaeto-Romance',
            'rn' => 'Kirundi',
            'ro' => 'Romanian',
            'ru' => 'Russian',
            'rw' => 'Kinyarwanda',
            'sa' => 'Sanskrit',
            'sd' => 'Sindhi',
            'sg' => 'Sangro',
            'sh' => 'Serbo-Croatian',
            'si' => 'Singhalese',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'sm' => 'Samoan',
            'sn' => 'Shona',
            'so' => 'Somali',
            'sq' => 'Albanian',
            'sr' => 'Serbian',
            'ss' => 'Siswati',
            'st' => 'Sesotho',
            'su' => 'Sundanese',
            'sv' => 'Swedish',
            'sw' => 'Swahili',
            'ta' => 'Tamil',
            'te' => 'Tegulu',
            'tg' => 'Tajik',
            'th' => 'Thai',
            'ti' => 'Tigrinya',
            'tk' => 'Turkmen',
            'tl' => 'Tagalog',
            'tn' => 'Setswana',
            'to' => 'Tonga',
            'tr' => 'Turkish',
            'ts' => 'Tsonga',
            'tt' => 'Tatar',
            'tw' => 'Twi',
            'uk' => 'Ukrainian',
            'ur' => 'Urdu',
            'uz' => 'Uzbek',
            'vi' => 'Vietnamese',
            'vo' => 'Volapuk',
            'wo' => 'Wolof',
            'xh' => 'Xhosa',
            'yo' => 'Yoruba',
            'zh' => 'Chinese',
            'zu' => 'Zulu',
        );
        return $language_codes;
    }
}
if (!function_exists('check_empty')) {
    function check_empty($data, $url)
    {
        if (empty($data)) {
            $message['title'] = 'Error';
            $message['text'] = "No Data Available";
            Session::put('message', $message);
            return Redirect('/' . $url);
        }
        return true;

    }
}
if (!function_exists('get_pusher')) {
    function get_pusher()
    {
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true,
        );
        $pusher = new Pusher\Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        return $pusher;
    }
}