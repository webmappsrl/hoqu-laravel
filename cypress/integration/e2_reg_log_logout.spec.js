import faker from 'faker'
import { last } from 'lodash'


describe('Registration', () => {
  const email = faker.internet.email()
  const password = faker.internet.password()

  it('register', () => {
      cy.visit('/register')
      const a = faker.name.findName();
      cy.get('input[name=name]').type(a)
      cy.get('input[name=email]').type(email)
      cy.get('input[name=password]').type(password)
      cy.get('input[name=password_confirmation]').type(password)
      cy.get('button').contains('Register').click()
      cy.url().should('contain', '/')

      cy.get('button.flex.text-sm.border-2.border-transparent.rounded-full').click()
      cy.get('a.block.px-4.py-2.text-sm.leading-5.text-gray-700').contains('Logout').click()

   })
  })


