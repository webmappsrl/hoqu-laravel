
describe('Registration', () => {
    //FASE LOGIN
    const email = 'team@webmapp.it'
    const password = 'T1tup4atmA'

    it('e2e1', () => {
        cy.visit('/login')
        const a = 'team';
        cy.get('input[name=email]').type(email)
        cy.get('input[name=password]').type(password)
        cy.get('button').contains('Login').click()

        //ASSERT HOME BASE
        cy.url().should('contain', '/')

        //check the data that are in ascending order
        var time_prev = 0
        var time = 0
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {

            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isBelow(time_prev, time, 'previous date is below actual')
            time_prev = time
        })

        //check that the data with status new and processing are present
        cy.get('#hometable > tbody > tr > td:nth-child(5)').each(($e, index, $list) => {
            const text = $e.text()
            if (text.includes('new')) {
                assert.strictEqual(text, 'new', 'new ok')
            }
            if (text.includes('processing')) {
                assert.strictEqual(text, 'processing', 'processing ok ')
            }

        })

        //ASSERT HOME page 2
        cy.get('a.relative.inline-flex.items-center').contains('2').click()
        cy.url().should('contain', '/?page=2')

        //check the data that are in ascending order

        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
          if (index == 0)time_prev=0
            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isBelow(time_prev, time, 'previous date is below actual')
            time_prev = time
        })

        //check that the data with status new and processing are present
        cy.get('#hometable > tbody > tr > td:nth-child(5)').each(($e, index, $list) => {
            const text = $e.text()
            if (text.includes('new')) {
                assert.strictEqual(text, 'new', 'new ok')
            }
            if (text.includes('processing')) {
                assert.strictEqual(text, 'processing', 'processing ok ')
            }

        })

        //ASSERT HOME page 3
        cy.get('a.relative.inline-flex.items-center').contains('3').click()
        cy.url().should('contain', '/?page=3')
        //check the data that are in ascending order
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            if (index == 0){time_prev=0}
            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isBelow(time_prev, time, 'previous date is below actual')
            time_prev = time
        })

        //check that the data with status new and processing are present
        cy.get('#hometable > tbody > tr > td:nth-child(5)').each(($e, index, $list) => {
            const text = $e.text()
            if (text.includes('new')) {
                assert.strictEqual(text, 'new', 'new ok')
            }
            if (text.includes('processing')) {
                assert.strictEqual(text, 'processing', 'processing ok ')
            }

        })

        //ASSERT HOME page 4
        cy.get('a.relative.inline-flex.items-center').contains('4').click()
        cy.url().should('contain', '/?page=4')

        //check the data that are in ascending order
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            if (index == 0)time_prev=0
            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isBelow(time_prev, time, 'previous date is below actual')
            time_prev = time
        })

        //check that the data with status new and processing are present
        cy.get('#hometable > tbody > tr > td:nth-child(5)').each(($e, index, $list) => {
            const text = $e.text()
            if (text.includes('new')) {
                assert.strictEqual(text, 'new', 'new ok')
            }
            if (text.includes('processing')) {
                assert.strictEqual(text, 'processing', 'processing ok ')
            }

        })
        cy.get('button.flex.text-sm.border-2.border-transparent.rounded-full').click()
        cy.get('a.block.px-4.py-2.text-sm.leading-5.text-gray-700').contains('Logout').click()



    })
})
