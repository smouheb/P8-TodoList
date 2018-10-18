Feature: User allocated to a task
  In order to remember which task I have created
  As connected user
  I need to be able to create a task that will be attached to me

  Background:
    Given I am on "/"

  Scenario Outline: userid persisted when task created by a user
    When I follow "Se connecter"
    And I fill in "Nom d'utilisateur" with "<username>"
    And I fill in "Mot de passe" with "<password>"
    And I press "Se connecter"
    Then I should see "Se déconnecter"
    When I follow "Créer une nouvelle tâche"
    Then I am on "/tasks/create"
    And I fill in "task_title" with "<title>"
    And I fill in "task_content" with "<content>"
    And I press "Ajouter"
    Then | I should see the id of the "<username>" in the database

  Examples:
    |username   |password|title     |content                   |
    |Smaeluser  |1234    |  Test1   |   This should be id 6    |
    |Yo         |1234    |  Test2   |   This should be id 3    |
    |Smael      |1234    |  Test3   |   This should be id 1    |