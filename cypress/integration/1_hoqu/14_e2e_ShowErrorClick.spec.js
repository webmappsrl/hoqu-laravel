
describe('Button Reschedule Error', () => {
    //FASE LOGIN
    const email = 'team@webmapp.it'
    const password = 'webmapp'

    it('e2eReschedule', () => {
        cy.visit('/login')
        const a = 'team';
        cy.get('input[name=email]').type(email)
        cy.get('input[name=password]').type(password)
        cy.get('button').contains('Login').click()

        //ASSERT HOME BASE
        cy.url().should('contain', '/')

        cy.get('body > div > main > div > div > div > header > div:nth-child(1) > button').click()
        cy.get('span#link_error').click()
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(2) > div > div > a').click()
        cy.get('button#editRes').click()
        //check Cancel
        cy.get('button#buttonCancel').click()
        cy.get('h4#processStatus').each(($e, index, $list) => {
            const text = $e.text()
            expect(text).to.contain('error')

        })
        //check Reschedule
        cy.get('button#editRes').click()
        cy.contains('Reschedule').click()
        cy.wait(5000)
        cy.get('h4#processStatus').each(($e, index, $list) => {
            const text = $e.text()
            expect(text).to.contain('new')

        })

        //check Skip
        cy.get('body > div > main > div > div > div > header > div:nth-child(1) > button').click()
        cy.get('span#link_error').click()
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(2) > div > div > a').click()
        cy.get('button#editShow').click()
        //check Cancel
        cy.get('button#buttonCancel').click()
        cy.get('h4#processStatus').each(($e, index, $list) => {
            const text = $e.text()
            expect(text).to.contain('error')

        })
        cy.get('button#editShow').click()
        cy.contains('Skip').click()
        cy.wait(5000)
        cy.get('h4#processStatus').each(($e, index, $list) => {
            const text = $e.text()
            expect(text).to.contain('skip')

        })







    })
})
