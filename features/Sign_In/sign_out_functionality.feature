Feature: Sign Out

Scenario Outline: Verify click functionality of the Sign Out

Given Open browser and Start Application again"<url>"
When I enter valid entry "<user>" and "<pass>"
Then I Click on sign in button
Then User must successfully logged in to the site

When I click on sign-out button
Then User must successfully logged out "<url>"

When I click on back button
Then The login page must be redirect "<url>"

Examples: 

| url                                      | user            | pass     |
| http://timetrackingwip.prdxnstaging.com/ | admin@prdxn.com | admin123 |

