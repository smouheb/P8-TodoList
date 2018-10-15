Feature: Tasks management
  In order to maintain tasks show on the site
  As a user
  I need to be able to create/edit/delete a task

  Background:
    Given I am on "/"

  Scenario: Create a Task
    When I follow "Se connecter"
    And I fill in "Nom d'utilisateur" with "Smaeluser"
    And I fill in "Mot de passe" with "1234"
    And I press "Se connecter"
    Then I should see "Se déconnecter"
    When I follow "Créer une nouvelle tâche"
    Then I am on "/tasks/create"
    And I fill in "task_title" with "Test Behat task form"
    And I fill in "task_content" with "This is the test content"
    And I press "Ajouter"
    Then I should see "La tâche a été bien été ajoutée."

  Scenario: Edit Task
    When I follow "Se connecter"
    And I fill in "Nom d'utilisateur" with "Smaeluser"
    And I fill in "Mot de passe" with "1234"
    And I press "Se connecter"
    Then I should see "Se déconnecter"
    And I am on "/tasks"
    Then I follow "TestSma1"
    And I fill in "task_title" with "Test edit"
    And  I fill in "task_content" with "Test edit content"
    And I press "Modifier"
    Then I should see "La tâche a bien été modifiée."

  Scenario: list of all tasks
    When  I follow "Consulter la liste des tâches à faire"
    Then I am on "/tasks"
    And I should see "Marquer comme faite"

  Scenario: Delete task created by its user
    When I follow "Se connecter"
    And I fill in "Nom d'utilisateur" with "Smaeluser"
    And I fill in "Mot de passe" with "1234"
    And I press "Se connecter"
    Then I should see "Se déconnecter"
    When  I follow "list_tasks"
    Then I am on "/tasks"
    And I should see "TestSma1"
    And I press "Supprimer"
    Then I should see "Superbe"

  Scenario: Delete task created by another user
    When I follow "Se connecter"
    And I fill in "Nom d'utilisateur" with "Yo"
    And I fill in "Mot de passe" with "1234"
    And I press "Se connecter"
    Then I should see "Se déconnecter"
    When I am on "/tasks"
    And I press "Supprimer"
    Then I should see "Oops"

    @changeuser
  Scenario: Delete a task that has been created by an anonymous user as an admin
    When I follow "Se connecter"
    And I fill in "Nom d'utilisateur" with "Smael"
    And I fill in "Mot de passe" with "1234"
    And I press "Se connecter"
    Then I should see "Se déconnecter"
    When I am on "/tasks"
    And I should see "TestSma3"
    And I press "Supprimer"
    Then I should see "La tâche a bien été supprimée."

  Scenario: Delete a task that has been created by an anonymous user as none admin
    When I follow "Se connecter"
    And I fill in "Nom d'utilisateur" with "Yo"
    And I fill in "Mot de passe" with "1234"
    And I press "Se connecter"
    Then I should see "Se déconnecter"
    When I am on "/tasks"
    And I should see "TestSma4"
    When I press "Supprimer"
    Then I should see "Oops"

  Scenario: Complete task
    Given I am on "/tasks"
    When I press "Marquer comme faite"
    Then I should see "Superbe !"