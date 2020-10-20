
describe('Registration', () => {
    //FASE LOGIN
    const email = 'team@webmapp.it'
    const password = 'webmapp'

    it('e2e1', () => {
        cy.visit('/login')
        const a = 'team';
        cy.get('input[name=email]').type(email)
        cy.get('input[name=password]').type(password)
        cy.get('button').contains('Login').click()

        //ASSERT HOME BASE
        cy.url().should('contain', '/')

        cy.get('span#link_duplicate').click()

        //ASSERT archive
        cy.url().should('contain', '/duplicate')


        //check the data that are in ascending order
        var time_prev = 0
        var time = 0
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {

            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isAtMost(time_prev, time, 'previous date is below actual')
            time_prev = time
        })

        //check that the data with status new and processing are present
        cy.get('#hometable > tbody > tr > td:nth-child(5)').each(($e, index, $list) => {
            const text = $e.text()
            if (text.includes('duplicate')) {
                assert.strictEqual(text, 'duplicate', 'duplicate ok')
            }

        })


        cy.get('button.flex.text-sm.border-2.border-transparent.rounded-full').click()
        cy.get('a.block.px-4.py-2.text-sm.leading-5.text-gray-700').contains('Logout').click()



    })
})
