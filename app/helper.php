<?php

if (!function_exists('status_label')) {
    /**
     * Return the appropriate label or class based on the status.
     *
     * @param  string  $status
     * @return string
     */
    function status_label($status)
    {
        switch ($status) {
            case '0':
                return '<span>Pending</span>';
            case '1':
                return '<span>Submitted</span>';
            case '2':
                return '<span>Rejected</span>';
            case '3':
                return '<span>Repairing</span>';
			case '4':
                return '<span>Replacing</span>';
			case '5':
                return '<span>Received</span>';
			case '6':
                return '<span>Locally Closed</span>';
            default:
                return '<span>N/A</span>';
        }
    }
}
?>