
describe('Button Reschedule in Done', () => {
    //FASE LOGIN
    const email = 'team@webmapp.it'
    const password = 'webmapp'

    it('e2eSkipNewAndReschedulePlusSkipProcessing', () => {
        cy.visit('/login')
        const a = 'team';
        cy.get('input[name=email]').type(email)
        cy.get('input[name=password]').type(password)
        cy.get('button').contains('Login').click()

        //ASSERT HOME BASE
        cy.url().should('contain', '/')
        cy.get('body > div > main > div > div > div > header > div:nth-child(1) > button').click()

        cy.get('span#link_todo').click()

        //ASSERT todo
        cy.url().should('contain', '/todo')
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(2) > div > a\n').click()

        //check Skip
        cy.get('body > div > main > div > div > div > header > div:nth-child(1) > button').click()
        cy.get('span#link_todo').click()
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1) > div > div > a').click()
        cy.get('button#editShow').click()
        //check Cancel
        cy.contains('Cancel').click()
        cy.get('h4#processStatus').each(($e, index, $list) => {
            const text = $e.text()
            expect(text).to.contain('new')

        })
        cy.get('button#editShow').click()
        cy.contains('Skip').click()
        cy.wait(5000)
        cy.get('h4#processStatus').each(($e, index, $list) => {
            const text = $e.text()
            expect(text).to.contain('skip')

        })
        cy.get('body > div > main > div > div > div > header > div:nth-child(1) > button').click()
        cy.get('span#link_todo').click()
        cy.url().should('contain', '/todo')
        cy.get('#paginationDone > div > nav > div > div:nth-child(2) > span > span:nth-child(5) > button').click()
        cy.url().should('contain', '/todo?page=4')
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(2) > div > a\n').click()


        //check Reschedule
        cy.get('button#editRes').click()
        cy.contains('Reschedule').click()
        cy.wait(5000)
        cy.get('h4#processStatus').each(($e, index, $list) => {
            const text = $e.text()
            expect(text).to.contain('new')

        })
    })

})
