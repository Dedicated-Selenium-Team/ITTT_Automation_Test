Feature: Check All Projects Tabs

Scenario Outline: Verify click functionality of the All Projects Tabs button

Given Open browser and Start Application "<url>"
When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open
Then User should be in project
Then I should see the mouse pointer changes to the hand pointer on hovering on "<Tab>"
Then "<All projects>" button should be highlighted as I click on it "<Tab>"

Examples: 
| url                            | username        | password | All projects | Tab    |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | ui-id-1      | tabs-1 |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | ui-id-2      | tabs-2 |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | ui-id-3      | tabs-3 |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | ui-id-4      | tabs-4 |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 | ui-id-5      | tabs-5 |



