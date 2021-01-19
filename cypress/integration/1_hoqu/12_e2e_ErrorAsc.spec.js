
describe('Button Reschedule in Done', () => {
    //FASE LOGIN
    const email = 'team@webmapp.it'
    const password = 'webmapp'

    it('e2eErrorAscDesc', () => {
        cy.visit('/login')
        const a = 'team';
        cy.get('input[name=email]').type(email)
        cy.get('input[name=password]').type(password)
        cy.get('button').contains('Login').click()

        //ASSERT HOME BASE
        cy.url().should('contain', '/')
        cy.get('body > div > main > div > div > div > header > div:nth-child(1) > button').click()

        cy.get('span#link_error').click()

        //ASSERT done
        cy.url().should('contain', '/error')

         cy.get('select#dataAsc').select('asc')
        var time_prev = 0
        var time = 0
        cy.get('#hometable > tbody > tr > td:nth-child(7)').each(($e, index, $list) => {
            if (index == 0)time_prev=0
            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isBelow(time_prev, time, 'previous date is below actual')
            time_prev = time
        })

        cy.get('select#dataAsc').select('desc')

        cy.get('#hometable > tbody > tr > td:nth-child(7)').each(($e, index, $list) => {
            if (index == 0)time_prev=0
            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isAbove(time, time_prev, 'previous date is above actual')
            time_prev = time
        })
        cy.get('button.flex.text-sm.border-2.border-transparent.rounded-full').click()
        cy.get('a.block.px-4.py-2.text-sm.leading-5.text-gray-700').contains('Logout').click()

    })
})
