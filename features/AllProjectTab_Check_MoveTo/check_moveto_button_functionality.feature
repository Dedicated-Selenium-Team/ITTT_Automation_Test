Feature: Project Tab

Scenario Outline: verify the click functionality of the move to button in Project Tabs

Given Open browser and Start Application "<url>"

When I enter valid "<username>" and "<password>"
Then User should be logged in and home page should be open
Then User should be in project
Then I click the "<Project_Tab>", projects of estimates phase appears in WP
Then I should see the mouse pointer changes to the hand pointer on hovering on Move To button (Let us check this project "<project_number>" and "<Tab>")
And tool tip appears on hovering on move to button (Let us check this project "<project_number>" and "<Tab>")
Then I click the Move to button (Let us check this project "<project_number>" and "<Tab>")

Examples: 
| url                            | username        | password | Project_Tab | project_number | Tab    |
| http://ittt.prdxnstaging2.com/ | admin@prdxn.com | admin123 | ui-id-2     | 5              | tabs-2 |
| http://ittt.prdxnstaging2.com/ | admin@prdxn.com | admin123 | ui-id-3     | 5              | tabs-3 |
| http://ittt.prdxnstaging2.com/ | admin@prdxn.com | admin123 | ui-id-4     | 5              | tabs-4 |