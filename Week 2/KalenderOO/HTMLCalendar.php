<?php

namespace Calendar;


class HTMLCalendar
{
    private $days;
    private $widthRenderedCalendarInDays;

    public function __construct($days)
    {
        $this->days = $days;
        $this->widthRenderedCalendarInDays = count($this->days);
    }

    public function renderMonth($monthName, Month $month)
    {
        echo "<table class='calendar'>";
        $this->renderMonthName($monthName);
        $this->renderWeekDays();
        $this->renderDates($month);
        echo "</table>";
    }

    private function renderMonthName($monthName)
    {
        echo("<tr><td colspan='" . $this->widthRenderedCalendarInDays . "' id='calendar_month'>" . $monthName . "</td></tr>");
    }

    private function renderWeekDays()
    {
        $this->renderRowStart();

        foreach ($this->days as $dayName) {
            echo("<th>");
            echo($dayName);
            echo("</th>");
        }

        $this->renderRowEnd();
    }

    private function renderRowStart()
    {
        echo("<tr>");
    }

    private function renderRowEnd()
    {
        echo("</tr>");
    }

    private function renderDates(Month $month)
    {
        $this->renderRowStart();

        for ($count = 0; $count < $month->calculateOffsetAtStart($this->days); $count++) {
            $this->renderEmptyDay();
        }

        $day_count = 1;
        while ($count < ($this->widthRenderedCalendarInDays * $month->calculateNumberOfWeeks($this->days))) {
            if ($month->endOfMonth($day_count)) {
                $this->renderEmptyDay();
            } else {
                $this->renderDay($day_count, $count % $this->widthRenderedCalendarInDays);
                $day_count++;
            }

            $count++;

            if ($count % $this->widthRenderedCalendarInDays === 0) {
                $this->renderRowEnd();
                $this->renderRowStart();
            }
        }
        $this->renderRowEnd();
    }

    private function renderEmptyDay()
    {
        echo "<td class='calendar_entry'></td>";
    }

    private function renderDay($monthDay, $weekDay)
    {
        switch ($weekDay) {
            case 5:
                echo("<td class='calendar_entry saturday_entry'>");
                break;

            case 6:
                echo("<td class='calendar_entry sunday_entry'>");
                break;

            default:
                echo("<td class='calendar_entry'>");
                break;
        }

        echo("<div class='entry_date'>$monthDay</div>");
        echo("<div class='entry_line'></div>");
        echo("<div class='entry_line'></div>");
        echo("<div class='entry_line'></div>");
        echo("</td>");
    }
}