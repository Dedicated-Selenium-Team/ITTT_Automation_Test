Feature: Sign In Functionality

Scenario Outline: Verify click functionality of the Sign In Button
Given Open browser and Start Application "<url>"

When I enter "<username>" and "<password>"
Then Click on sign-in button
Then Proper error message must be appeared or successfully login

Examples: 
| url                                      | username        | password |
| http://timetrackingwip.prdxnstaging.com/ |                 |          | 
| http://timetrackingwip.prdxnstaging.com/ | abcd            | abcd     |