@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="generator" content="PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet">
    <meta name="author" content="KOMA"/>
    <link href='https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;200;300;400;500;600' rel='stylesheet'>
    <style type="text/css">
        html, body {
            font-family: "Noto Sans JP", sans-serif;
            font-size: 9pt;
            background-color: white
        }

        a.comment-indicator:hover + div.comment {
            background: #ffd;
            position: absolute;
            display: block;
            border: 1px solid black;
            padding: 0.5em
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .s {
            text-align: left
        }

        td.style10 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style10 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style11 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style11 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style12 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style12 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style13 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style13 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style14 {
            vertical-align: middle;
            border-bottom: none #000000;

            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style14 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style15 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style15 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style16 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style16 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style17 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style17 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style18 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style18 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style19 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style19 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style20 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style20 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style21 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style21 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style23 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style23 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style24 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            background-color: white
        }

        th.style24 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 22pt;
            background-color: white
        }

        td.style25 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style25 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style26 {
            padding-left: 5px;
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style26 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style27 {
            vertical-align: middle;
            text-align: right;
            padding-right: 0px;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 10pt;
            background-color: white
        }

        th.style27 {
            vertical-align: middle;
            text-align: right;
            padding-right: 0px;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 10pt;
            background-color: white
        }

        td.style28 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style28 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style30 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style30 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style31 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style31 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style32 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style32 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style33 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style33 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style35 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style35 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style36 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style36 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style39 {
            vertical-align: middle;
            text-align: right;
            padding-right: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 10pt;
            background-color: white
        }

        th.style39 {
            vertical-align: middle;
            text-align: right;
            padding-right: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 10pt;
            background-color: white
        }

        td.style40 {
            vertical-align: middle;
            text-align: right;
            padding-right: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 10pt;
            background-color: white
        }

        th.style40 {
            vertical-align: middle;
            text-align: right;
            padding-right: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 10pt;
            background-color: white
        }

        td.style42 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style42 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style43 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style43 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style44 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style44 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style45 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style45 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style46 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style46 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style48 {
            vertical-align: middle;
            text-align: left;
            padding-left: 5px;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style48 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style49 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style49 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style51 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        th.style51 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: #FFFFFF
        }

        td.style52 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style52 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style53 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style53 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style54 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style54 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style55 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style55 {
            vertical-align: middle;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style56 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            background-color: white
        }

        th.style56 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 22pt;
            background-color: white
        }

        td.style57 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style57 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style59 {
            vertical-align: middle;
            text-align: left;
            padding-left: 5px;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style59 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 1px solid #000000 !important;
            border-top: 1px solid #000000 !important;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style60 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style60 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: none #000000;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style61 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style61 {
            vertical-align: middle;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style62 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style62 {
            vertical-align: middle;
            text-align: left;
            padding-left: 0px;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style65 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style65 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: none #000000;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style68 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style68 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: none #000000;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style69 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style69 {
            vertical-align: middle;
            text-align: center;
            border-bottom: none #000000;
            border-top: 1px solid #000000 !important;
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        td.style71 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        th.style71 {
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #000000 !important;
            border-top: none #000000;
            border-left: 1px solid #000000 !important;
            border-right: 1px solid #000000 !important;
            color: #000000;
            font-size: 9pt;
            background-color: white
        }

        table.sheet0 col.col0 {
            width: 27.78888857pt
        }

        table.sheet0 col.col1 {
            width: 27.78888857pt
        }

        table.sheet0 col.col2 {
            width: 27.78888857pt
        }

        table.sheet0 col.col3 {
            width: 27.78888857pt
        }

        table.sheet0 col.col4 {
            width: 27.78888857pt
        }

        table.sheet0 col.col5 {
            width: 27.78888857pt
        }

        table.sheet0 col.col6 {
            width: 27.78888857pt
        }

        table.sheet0 col.col7 {
            width: 27.78888857pt
        }

        table.sheet0 col.col8 {
            width: 27.78888857pt
        }

        table.sheet0 col.col9 {
            width: 27.78888857pt
        }

        table.sheet0 col.col10 {
            width: 27.78888857pt
        }

        table.sheet0 col.col11 {
            width: 27.78888857pt
        }

        table.sheet0 col.col12 {
            width: 27.78888857pt
        }

        table.sheet0 col.col13 {
            width: 27.78888857pt
        }

        table.sheet0 col.col14 {
            width: 27.78888857pt
        }

        table.sheet0 col.col15 {
            width: 27.78888857pt
        }

        table.sheet0 tr {
            height: 10pt
        }

        table.sheet0 tr.row0 {
            height: 10pt;
            font-size: 22pt;
        }

        table.sheet0 tr.row1 {
            height: 30pt
        }

        table.sheet0 tr.row2 {
            height: 10pt
        }

        table.sheet0 tr.row3 {
            height: 10pt
        }

        table.sheet0 tr.row4 {
            height: 10pt
        }

        table.sheet0 tr.row5 {
            height: 10pt
        }

        table.sheet0 tr.row6 {
            height: 10pt
        }

        table.sheet0 tr.row7 {
            height: 10pt
        }

        table.sheet0 tr.row8 {
            height: 10pt
        }

        table.sheet0 tr.row9 {
            height: 10pt
        }

        table.sheet0 tr.row19 {
            height: 10pt
        }

        table.sheet0 tr.row21 {
            height: 10pt
        }

        table.sheet0 tr.row22 {
            height: 10pt
        }

        table.sheet0 tr.row26 {
            height: 10pt
        }

        table.sheet0 tr.row27 {
            height: 10pt
        }

        table.sheet0 tr.row28 {
            height: 10pt
        }

        table.sheet0 tr.row29 {
            height: 10pt
        }

        table.sheet0 tr.row34 {
            height: 10pt
        }

        table.sheet0 tr.row35 {
            height: 10pt
        }

        table.sheet0 tr.row36 {
            height: 10pt
        }

        table.sheet0 tr.row37 {
            height: 10pt
        }

        table.sheet0 tr.row38 {
            height: 10pt
        }

        table.sheet0 tr.row39 {
            height: 10pt
        }

        table.sheet0 tr.row41 {
            height: 10pt
        }

        table.sheet0 tr.row42 {
            height: 10pt
        }

        table.sheet0 tr.row43 {
            height: 10pt
        }

        table.sheet0 tr.row44 {
            height: 10pt
        }

        table.sheet0 tr.row46 {
            height: 10pt
        }

        table.sheet0 tr.row47 {
            height: 18pt
        }

        table.sheet0 tr.row48 {
            height: 18pt
        }

        table.sheet0 tr.row49 {
            height: 18pt
        }

        @page {
            margin-left: 0.78740157480315in;
            margin-right: 0.78740157480315in;
            margin-top: 0.78740157480315in;
            margin-bottom: 0.78740157480315in;
        }

        body {
            margin-left: 0.78740157480315in;
            margin-right: 0.78740157480315in;
            /* margin-top: 0.78740157480315in;
            margin-bottom: 0.78740157480315in; */
        }
    </style>
</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">
    <col class="col0">
    <col class="col1">
    <col class="col2">
    <col class="col3">
    <col class="col4">
    <col class="col5">
    <col class="col6">
    <col class="col7">
    <col class="col8">
    <col class="col9">
    <col class="col10">
    <col class="col11">
    <col class="col12">
    <col class="col13">
    <col class="col14">
    <col class="col15">
    <tbody>
    <tr class="row0">
        <td class="column0 style24 s style24" colspan="16">支払報告書</td>
    </tr>
    <tr class="row1">
        <td class="column0 style24 null" colspan="16">&nbsp;</td>
    </tr>
    <tr class="row2">
        <td class="column0 style39 s style39" colspan="8">利用明細番号</td>
        <td class="column8 style40 s style40" colspan="8">{{$report_code}}</td>
    </tr>
    <tr class="row3">
        <td class="column0 style27 s style27" colspan="8">加盟店</td>
        <td class="column8 style27 s style27" colspan="8">{{ formatAccountId($merchant_code) }} - {{$merchant_name}}</td>
    </tr>
    <tr class="row4">
        <td class="column0 style42 s style43" colspan="3">発行日</td>
        <td class="column3 style46 s style48" colspan="13">
            @if (app()->getLocale() == 'ja')
                {{ Carbon::parse($issue_date)->format('Y年m月d日') }}
            @else
                {{ Carbon::parse($issue_date)->format('Y/m/d') }}
            @endif
        </td>
    </tr>
    <tr class="row5">
        <td class="column0 style42 s style43" colspan="3">期間</td>
        <td class="column3 style36 s style26" colspan="13">
            @if (app()->getLocale() == 'ja')
                {{ Carbon::parse($period_from)->format('Y年m月d日') }} ~
                {{ Carbon::parse($period_to)->format('Y年m月d日') }}
            @else
                {{ Carbon::parse($period_from)->format('Y/m/d') }} ~
                {{ Carbon::parse($period_to)->format('Y/m/d') }}
            @endif
        </td>
    </tr>
    <tr class="row6">
        <td class="column0 style42 s style43" colspan="3">支払い先</td>
        <td class="column3 style25 s style26" colspan="13">
            {{ getWithdrawMethod($withdraw_method) }}
        </td>
    </tr>
    <tr class="row7">
        <td class="column0 style24 null" colspan="16">&nbsp;</td>
    </tr>
    <tr class="row8">
        <td class="column0 style49 s style51" colspan="3">取引金額情報</td>
        <td class="column3 style52 s style54" colspan="4">単位</td>
        <td class="column7 style52 s style54" colspan="4">取引回数</td>
        <td class="column11 style52 s style54" colspan="5">取引金額</td>
    </tr>
    @php
        $payment_amount = json_decode($payment_amount, true);
    @endphp
    @foreach ($payment_amount as $item)
        @if($item['asset'] != 'total')
            <tr class="row9">
                <td class="column0 style13 null"></td>
                <td class="column1 style23 null"></td>
                <td class="column2 style14 null"></td>
                <td class="column3 style57 s style59" colspan="4"> {{ $item['asset'] }}</td>
                <td class="column7 style52 null style54" colspan="4">{{ $item['count'] }}</td>
                <td class="column11 style52 null style54" colspan="5">{{ formatNumberDecimal($item['total']) }}</td>
            </tr>
        @else
            <tr class="row19">
                <td class="column0 style15 null"></td>
                <td class="column1 style16 null"></td>
                <td class="column2 style17 null"></td>
                <td class="column3 style52 s style54" colspan="4">合計</td>
                <td class="column7 style52 null style54" colspan="4">{{ $item['count'] }}</td>
                <td class="column11 style52 null style54" colspan="5">-</td>
            </tr>
        @endif
    @endforeach
    
    <tr class="row2">
        <td class="column0 style24 null style24" colspan="16">&nbsp;</td>
    </tr>
    <tr class="row21">
        <td class="column0 style49 s style51" colspan="3">受取金額情報</td>
        <td class="column3 style52 s style54" colspan="4">単位</td>
        <td class="column7 style52 s style54" colspan="4">取引回数</td>
        <td class="column11 style53 s style54" colspan="5">取引金額</td>
    </tr>
    @php
        $received_amount = json_decode($received_amount, true);
    @endphp
    @foreach ($received_amount as $item)
        @if($item['asset'] != 'total')
            <tr class="row22">
                <td class="column0 style13 null"></td>
                <td class="column1 style23 null"></td>
                <td class="column2 style14 null"></td>
                <td class="column3 style57 s style59" colspan="4">{{ $item['asset'] }}</td>
                <td class="column7 style52 null style54" colspan="4">{{ $item['count'] }}</td>
                <td class="column11 style53 null style54" colspan="5">{{ formatNumberDecimal($item['total']) }}</td>
            </tr>
        @else
            <tr class="row26">
                <td class="column0 style15 null"></td>
                <td class="column1 style16 null"></td>
                <td class="column2 style17 null"></td>
                <td class="column3 style52 s style54" colspan="4">合計</td>
                <td class="column7 style52 null style54" colspan="4">{{ $item['count'] }}</td>
                <td class="column11 style53 null style54" colspan="5">-</td>
            </tr>
        @endif
    @endforeach

    <tr class="row2">
        <td class="column0 style24 null style24" colspan="16">&nbsp;</td>
    </tr>
    <tr class="row28">
        <td class="column0 style49 s style51" colspan="3">出金額情報</td>
        <td class="column3 style52 s style54" colspan="2">単位</td>
        <td class="column5 style52 s style54" colspan="3">出金可能額</td>
        <td class="column8 style52 s style53" colspan="3">出金済額</td>
        <td class="column11 style52 s style54" colspan="2">出金手数料</td>
        <td class="column13 style52 s style54" colspan="3">出金予定額</td>
    </tr>
    @php
        $withdraw_amount = json_decode($withdraw_amount, true);
    @endphp
    @foreach ($withdraw_amount as $item)
        <tr class="row29">
            <td class="column0 style13 null"></td>
            <td class="column1 style23 null"></td>
            <td class="column2 style14 null"></td>
            <td class="column3 style57 s style59" colspan="2">{{ $item['asset'] }}</td>
            <td class="column5 style52 null style54" colspan="3">{{ formatNumberDecimal($item['withdrawable_amount']) }}</td>
            <td class="column8 style52 null style53" colspan="3">{{ formatNumberDecimal($item['withdrawn_amount']) }}</td>
            <td class="column11 style52 null style54" colspan="2">{{ formatNumberDecimal($item['withdrawal_fee']) }}</td>
            <td class="column13 style52 null style54" colspan="3">{{ formatNumberDecimal($item['planned_amount']) }}</td>
        </tr>
    @endforeach
    <tr class="row34">
        <td class="column0 style56 null style56" colspan="16">&nbsp;</td>
    </tr>
    <tr class="row35">
        <td class="column0 style13 null"></td>
        <td class="column1 style21 s">備考</td>
        <td class="column2 style14 null"></td>
        <td class="column3 style33 null style35" colspan="13">&nbsp;</td>
    </tr>
    <tr class="row36">
        <td class="column0 style10 null"></td>
        <td class="column1 style11 null"></td>
        <td class="column2 style12 null"></td>
        <td class="column3 style31 null style32" colspan="13">&nbsp;</td>
    </tr>
    <tr class="row37">
        <td class="column0 style10 null"></td>
        <td class="column1 style11 null"></td>
        <td class="column2 style12 null"></td>
        <td class="column3 style31 null style32" colspan="13">&nbsp;</td>
    </tr>
    <tr class="row38">
        <td class="column0 style10 null"></td>
        <td class="column1 style11 null"></td>
        <td class="column2 style12 null"></td>
        <td class="column3 style31 null style32" colspan="13"></td>
    </tr>
    <tr class="row39">
        <td class="column0 style15 null"></td>
        <td class="column1 style16 null"></td>
        <td class="column2 style17 null"></td>
        <td class="column3 style28 null style30" colspan="13"></td>
    </tr>
    
    </tbody>
</table>
</body>
</html>
