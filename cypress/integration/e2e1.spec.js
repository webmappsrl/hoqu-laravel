import faker from 'faker'
import { last } from 'lodash'


describe('Registration', () => {
  const email = faker.internet.email()
  const password = faker.internet.password()

  it('e2e1', () => {
      cy.visit('/register')
      const a = faker.name.findName();
      cy.get('input[name=name]').type(a)
      cy.get('input[name=email]').type(email)
      cy.get('input[name=password]').type(password)
      cy.get('input[name=password_confirmation]').type(password)
      cy.get('button').contains('Register').click()
      cy.url().should('contain', '/')

      var time_prev = 0
      var time = 0
      cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e,index,$list) => {
       
        time = (new Date($e.text()).getTime()/1000)
        assert.isBelow(time_prev, time, 'previous date is below actual')
        time_prev = time
      })
      cy.get('#hometable > tbody > tr > td:nth-child(5)').each(($e,index,$list) => {
        const text = $e.text()
        if (text.includes('new')) 
        {
          assert.strictEqual(text, 'new', 'new ok')
        }
        if (text.includes('processing')) 
        {
          assert.strictEqual(text, 'processing', 'processing ok ')
        }

      })
       cy.get('a.relative.inline-flex.items-center').contains('2').click()
       cy.url().should('contain', '/?page=2')
       cy.get('#hometable > tbody > tr > td:nth-child(5)').each(($e,index,$list) => {
        const text = $e.text()
        if (text.includes('new')) 
        {
          assert.strictEqual(text, 'new', 'new ok')
        }
        if (text.includes('processing')) 
        {
          assert.strictEqual(text, 'processing', 'processing ok ')
        }

      })
       cy.get('a.relative.inline-flex.items-center').contains('3').click()
       cy.url().should('contain', '/?page=3')
       cy.get('#hometable > tbody > tr > td:nth-child(5)').each(($e,index,$list) => {
        const text = $e.text()
        if (text.includes('new')) 
        {
          assert.strictEqual(text, 'new', 'new ok')
        }
        if (text.includes('processing')) 
        {
          assert.strictEqual(text, 'processing', 'processing ok ')
        }

      })
       cy.get('a.relative.inline-flex.items-center').contains('4').click()
       cy.url().should('contain', '/?page=4')
       cy.get('#hometable > tbody > tr > td:nth-child(5)').each(($e,index,$list) => {
        const text = $e.text()
        if (text.includes('new')) 
        {
          assert.strictEqual(text, 'new', 'new ok')
        }
        if (text.includes('processing')) 
        {
          assert.strictEqual(text, 'processing', 'processing ok ')
        }

      })
      cy.get('button.flex.text-sm.border-2.border-transparent.rounded-full').click()
      cy.get('a.block.px-4.py-2.text-sm.leading-5.text-gray-700').contains('Logout').click()


   })
  })


