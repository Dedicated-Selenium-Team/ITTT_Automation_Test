Feature: Sign In

Scenario Outline: Verify click functionality of the Login In and click back button

Given Open browser and Start Application (for back button)"<url>"
When I enter the valid "<user>" and "<pass>"
Then Click on sign in button
Then User must successfully logged-in

When I click back button
Then The current page should not be redirected to the login page"<url>"

Examples: 
| url                            | user            | pass     |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 |

