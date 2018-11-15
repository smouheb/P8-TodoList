Feature: User management
  In order to share the application with my team
  As an admin user
  I need to be able to create/edit users

  Background:
    Given I am on "/"
    When I follow "Se connecter"
    Then I should see "Nom d'utilisateur :"
    And I fill in "Nom d'utilisateur" with "Smaeladmin"
    And I fill in "Mot de passe" with "1234"

  Scenario: Create a user
    When I press "Se connecter"
    Then I follow "Créer un utilisateur"
    And I fill in "Nom d'utilisateur" with "TestUserBehat"
    And I fill in "Mot de passe" with "1234"
    And I fill in "Tapez le mot de passe à nouveau" with "1234"
    And I fill in "Adresse email" with "TestUserBehat@test.com"
    And I select "User" from "Role"
    And I press "Ajouter"
    Then I should see "Superbe !"

  Scenario: Edit user
    When I press "Se connecter"
    Then I am on "/users"
    And I should see "Liste des utilisateurs"
    When I follow "Edit"
    Then I should see "Role"
    And I select "Admin" from "Role"
    And I fill in "Mot de passe" with "1234"
    And I fill in "Tapez le mot de passe à nouveau" with "1234"
    And I press "Modifier"
    Then I should see "Superbe !"
