Feature: Authentication
  In order to gain access to the application to benefit from different functionalities
  As a user
  I need to be able to login and logout

  Background:
    Given I am on "/"


  Scenario: Wrong password
    When I follow "Se connecter"
    Then I should see "Nom d'utilisateur :"
    And I fill in "Nom d'utilisateur" with "Smael"
    And I fill in "Mot de passe" with "XXXX"
    And I press "Se connecter"
    Then I should see "Invalid credentials"

  Scenario: Wrong User
    When I follow "Se connecter"
    Then I should see "Nom d'utilisateur :"
    And I fill in "Nom d'utilisateur" with "TesBe"
    And I fill in "Mot de passe" with "1234"
    And I press "Se connecter"
    Then I should see "Invalid credentials"

  Scenario: User correct login
    When I follow "Se connecter"
    Then I should see "Nom d'utilisateur :"
    And I fill in "Nom d'utilisateur" with "Smael"
    And I fill in "Mot de passe" with "1234"
    And I press "Se connecter"
    Then I should see "Se déconnecter"

  Scenario: Form for user creation
    When I follow "Se connecter"
    Then I should see "Nom d'utilisateur :"
    And I fill in "Nom d'utilisateur" with "Smael"
    And I fill in "Mot de passe" with "1234"
    And I press "Se connecter"
    When I follow "Créer un utilisateur"
    Then I should see "Créer un utilisateur"
    And I should see "Nom d'utilisateur"
    And I should see "Mot de passe"
    And I should see "Tapez le mot de passe à nouveau"
    And I should see "Adresse email"
    And I should see "Role"
    And I should see "User"
    And I should see "Admin"

