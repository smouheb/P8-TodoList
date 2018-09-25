Feature: Tasks management
  In order to maintain tasks show on the site
  As a user
  I need to be able to create/edit/delete a task

  Scenario: list of all tasks
    Given |I am on "/"
    When I click on "/tasks"
    Then I should see the list of all tasks

  Scenario: Create a Task
    Given |I am on "/tasks"
    When I click "Créer une tâche"
    And |I fill in "task_title" with "Test Behat task form"
    And |I fill in "task_content" with "This is the test content"
    And |I press "Ajouter"
    Then |I should see "La tâche a été bien été ajoutée."

  Scenario: Edit Task
    Given |I am on "/tasks"
    When I click on a Task's title
    Then I should be able to edit the task
    When |I fill in "task_title" with "Test edit"
    And |I fill in "task_content" with "Test edit content"
    And |I press "Modifier"
    Then |I should see "La tâche a bien été modifiée."

  Scenario: Delete task created by its user
    Given |I am on "/tasks"
    And |I am the user who created the task
    When |I press "Supprimer"
    Then |I should see "La tâche a bien été supprimée."

  Scenario: Delete task created by another user
    Given |I am on "/tasks"
    And I am not the user who created the task
    When |I press "Supprimer"
    Then |I should see "La tâche %s ne peut être supprimée que part le user qui l' a crée."

  Scenario: Delete a task that has been created by an anonymous user as an admin
    Given |I am on "/tasks"
    And I am an admin user
    When |I press "Supprimer"
    Then |I should see "La tâche a bien été supprimée."

  Scenario: Delete a task that has been created by an anonymous user as none admin
    Given |I am on "/tasks"
    And I am not the user who created the task
    When |I press "Supprimer"
    Then |I should see "La tâche %s ne peut être supprimée que part le user qui l' a crée."

  Scenario: Complete task
    Given |I am on "<string>"
    When |I press "Marquer comme faite"
    Then |I should see "La tâche %s a bien été marquée comme faite."