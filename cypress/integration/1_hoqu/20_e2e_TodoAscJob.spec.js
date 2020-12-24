
describe('Button Reschedule in Done', () => {
    //FASE LOGIN
    const email = 'team@webmapp.it'
    const password = 'webmapp'

    it('e2eRescheduleDone', () => {
        cy.visit('/login')
        const a = 'team';
        cy.get('input[name=email]').type(email)
        cy.get('input[name=password]').type(password)
        cy.get('button').contains('Login').click()

        //ASSERT HOME BASE
        cy.url().should('contain', '/')
        cy.get('body > div > main > div > div > div > header > div:nth-child(1) > button').click()

        cy.get('span#link_todo').click()

        //ASSERT done
        cy.url().should('contain', '/todo')

         cy.get('select#dataAsc').select('asc')
        var time_prev = 0
        var time = 0
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            if (index == 0)time_prev=0
            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isBelow(time_prev, time, 'previous date is below actual')
            time_prev = time
        })

        cy.get('select#dataAsc').select('desc')

        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            if (index == 0)time_prev=0
            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isAbove(time, time_prev, 'previous date is above actual')
            time_prev = time
        })

        cy.get('select#selectJob').select('Et.')
        cy.wait(1000)
        cy.get('#hometable > tbody > tr > td:nth-child(3)').each(($e, index, $list) => {
            expect($e.text()).to.contain('Et.')
        })
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            if (index == 0){time_prev=0}
            expect(Cypress.moment($e.text()).isAfter(Cypress.moment(time_prev))).to.be.true;
            time_prev = time

        })

        cy.get('select#dataAsc').select('asc')
        cy.wait(1000)
        cy.get('#hometable > tbody > tr > td:nth-child(3)').each(($e, index, $list) => {
            expect($e.text()).to.contain('Et.')
        })
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            if (index == 0)time_prev=0
            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isBelow(time_prev, time, 'previous date is below actual')
            time_prev = time
        })

        cy.get('select#selectInstance').select('montepisano.org')
        cy.wait(1000)
        cy.get('#hometable > tbody > tr > td:nth-child(2)').each(($e, index, $list) => {
            expect($e.text()).to.contain('montepisano.org')
        })
        cy.get('#hometable > tbody > tr > td:nth-child(3)').each(($e, index, $list) => {
            expect($e.text()).to.contain('Et.')
        })
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            if (index == 0)time_prev=0
            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isBelow(time_prev, time, 'previous date is below actual')
            time_prev = time
        })
        cy.get('select#dataAsc').select('desc')
        cy.wait(1000)

        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            if (index == 0){time_prev=0}
            expect(Cypress.moment($e.text()).isAfter(Cypress.moment(time_prev))).to.be.true;
            time_prev = time

        })


    })
})
