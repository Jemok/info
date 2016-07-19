<?php
	/**
     * Every other day - forever:
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=DAILY;INTERVAL=2
     */
    function testDailyThree()
    {
        $results[] = new DateTime('1997-09-02 09:00:00');
        $results[] = new DateTime('1997-09-04 09:00:00');
        $results[] = new DateTime('1997-09-06 09:00:00');
        $results[] = new DateTime('1997-09-08 09:00:00');
        $results[] = new DateTime('1997-09-10 09:00:00');
        $results[] = new DateTime('1997-09-12 09:00:00');
        $results[] = new DateTime('1997-09-14 09:00:00');
        $results[] = new DateTime('1997-09-16 09:00:00');
        $results[] = new DateTime('1997-09-18 09:00:00');
        $results[] = new DateTime('1997-09-20 09:00:00');
        $results[] = new DateTime('1997-09-22 09:00:00');
        $results[] = new DateTime('1997-09-24 09:00:00');
        $results[] = new DateTime('1997-09-26 09:00:00');
        $results[] = new DateTime('1997-09-28 09:00:00');
        $results[] = new DateTime('1997-09-30 09:00:00');
        $results[] = new DateTime('1997-10-02 09:00:00');
        $results[] = new DateTime('1997-10-04 09:00:00');
        $results[] = new DateTime('1997-10-06 09:00:00');
        $results[] = new DateTime('1997-10-08 09:00:00');
        $results[] = new DateTime('1997-10-10 09:00:00');
        $results[] = new DateTime('1997-10-12 09:00:00');
        $results[] = new DateTime('1997-10-14 09:00:00');
        $results[] = new DateTime('1997-10-16 09:00:00');
        $results[] = new DateTime('1997-10-18 09:00:00');
        $results[] = new DateTime('1997-10-20 09:00:00');
        $results[] = new DateTime('1997-10-22 09:00:00');
        $results[] = new DateTime('1997-10-24 09:00:00');
        $results[] = new DateTime('1997-10-26 09:00:00');
        $results[] = new DateTime('1997-10-28 09:00:00');
        $results[] = new DateTime('1997-10-30 09:00:00');
        $results[] = new DateTime('1997-11-01 09:00:00');
        $results[] = new DateTime('1997-11-03 09:00:00');
        $results[] = new DateTime('1997-11-05 09:00:00');
        $results[] = new DateTime('1997-11-07 09:00:00');
        $results[] = new DateTime('1997-11-09 09:00:00');
        $results[] = new DateTime('1997-11-11 09:00:00');
        $results[] = new DateTime('1997-11-13 09:00:00');
        $results[] = new DateTime('1997-11-15 09:00:00');
        $results[] = new DateTime('1997-11-17 09:00:00');
        $results[] = new DateTime('1997-11-19 09:00:00');
        $results[] = new DateTime('1997-11-21 09:00:00');
        $results[] = new DateTime('1997-11-23 09:00:00');
        $results[] = new DateTime('1997-11-25 09:00:00');
        $results[] = new DateTime('1997-11-27 09:00:00');
        $results[] = new DateTime('1997-11-29 09:00:00');
        $results[] = new DateTime('1997-12-01 09:00:00');
        $results[] = new DateTime('1997-12-03 09:00:00');

        $r = new When();
        $r->startDate(new DateTime("19970902T090000"))
          ->freq("daily")
          ->interval(2)
          ->count(47)
          ->generateOccurrences();

        $occurrences = $r->occurrences;

        foreach ($results as $key => $result)
        {
            $this->assertEquals($result, $occurrences[$key]);
        }
    }
	
	testDailyThree();
?>