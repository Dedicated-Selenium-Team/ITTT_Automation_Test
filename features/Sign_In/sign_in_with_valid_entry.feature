Feature: Sign In With Valid Entry

Scenario Outline: Verify click functionality of the Sign In with valid entry
Given Open browser and Start Application for valid login"<url>"

When I enter the valid "<username>" and "<password>"
Then Click sign in button
Then User must successfully signed in to the site

Examples: 
| url                                      | username        | password |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 |

