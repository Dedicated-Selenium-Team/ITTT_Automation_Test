Feature: Click Week or Day view calender

Scenario Outline: Verify click functionality for the day view calender

Given Open browser and Start Application "<url>"

When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open

When Click on the week and day "<view>"
Then The respective "<table>" should be get displayed
Then Click on the Calendar icon
Then Click on the any date between Week (Let say "<date>" "<month>" "<year>")

Examples: 
| url                            | username        | password | view   | date | month | year | table       |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | a.day  | 15   | Nov   | 2015 | .day-table  |

