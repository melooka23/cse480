<?php

class BaseView {

    public static function DisplayTitle($title) {
        print "<h2>" . $title . "</h2>" . PHP_EOL;
    }

    public static function DisplaySubmit($class, $submits) {
        print '<div class="' . $class . '">' . PHP_EOL;
        foreach ($submits as $submitkey => $submitvalue) {
            if (is_array($submitvalue))
                foreach ($submitvalue as $value)
                    print '<input type="submit" name="' . $submitkey . '" value="' . $value . '">' . PHP_EOL;
            else
                print '<input type="submit" name="' . $submitkey . '" value="' . $submitvalue . '">' . PHP_EOL;
        }
        print '</div>' . PHP_EOL;
    }

    public static function DisplayTable($results, $nav, $id = "mytable") {
        print '<script>' . PHP_EOL;
        print '$(document).ready(function(){';
        print '$("#' . $id . '").tablesorter({';
        print 'widgets: ["zebra"], widgetZebra: { css: [ "alt", "" ] }';
        print '});});';
        print 'function DoNav(the_link) {';
        print 'document.location.href = the_link;';
        print '}' . PHP_EOL;
        print '</script>' . PHP_EOL;
        print '<div class="creator">' . PHP_EOL;
        print '<table id="' . $id . '" class="tablesorter">' . PHP_EOL;
        print '<thead>' . PHP_EOL;
        print '<tr>' . PHP_EOL;

        foreach ($results as $row) {
            foreach ($row as $field => $value)
                print '<th>' . $field . '</th>' . PHP_EOL;
            break;
        }
        print '</tr>' . PHP_EOL;
        print '</thead>' . PHP_EOL;
        print '<tbody>' . PHP_EOL;
        reset($results);
        foreach ($results as $rowid => $row) {
            print '<tr onclick="DoNav(\'' . $nav . $rowid . '\')">' . PHP_EOL;
            foreach ($row as $value)
                print '<td>' . $value . '</td>' . PHP_EOL;
            print '</tr>' . PHP_EOL;
        }
        print '</tbody>' . PHP_EOL;
        print '<tfoot>' . PHP_EOL;
        print '</tfoot>' . PHP_EOL;
        print '</table>' . PHP_EOL;
        print '</div>' . PHP_EOL;
    }

    public static function DisplayTableNoLink($results, $id = "mytable") {
        print '<script>' . PHP_EOL;
        print '$(document).ready(function(){';
        print '$("#' . $id . '").tablesorter({';
        print 'widgets: ["zebra"], widgetZebra: { css: [ "alt", "" ] }';
        print '});});';
        print '</script>' . PHP_EOL;
        print '<div class="creator">' . PHP_EOL;
        print '<table id="' . $id . '" class="tablesorter">' . PHP_EOL;
        print '<thead>' . PHP_EOL;
        print '<tr>' . PHP_EOL;

        foreach ($results as $row) {
            foreach ($row as $field => $value)
                print '<th>' . $field . '</th>' . PHP_EOL;
            break;
        }
        print '</tr>' . PHP_EOL;
        print '</thead>' . PHP_EOL;
        print '<tbody>' . PHP_EOL;
        reset($results);
        foreach ($results as $rowid => $row) {
            print '<tr>' . PHP_EOL;
            foreach ($row as $value)
                print '<td>' . $value . '</td>' . PHP_EOL;
            print '</tr>' . PHP_EOL;
        }
        print '</tbody>' . PHP_EOL;
        print '<tfoot>' . PHP_EOL;
        print '</tfoot>' . PHP_EOL;
        print '</table>' . PHP_EOL;
        print '</div>' . PHP_EOL;
    }
    
}
