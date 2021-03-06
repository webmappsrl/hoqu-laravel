describe('New and Processing', () => {
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
        cy.get('body > div > main > div > div > div > header > div:nth-child(1) > button').click()

        cy.get('span#link_todo').click()

        //ASSERT archive
        cy.url().should('contain', '/todo')

        //check the data that are in ascending order
        var time_prev = 0
        var time = 0
        cy.get('#hometable > tbody > tr > td:nth-child(7)').each(($e, index, $list) => {

            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isBelow(time_prev, time, 'previous date is below actual')
            time_prev = time
        })

        //check that the data with status new and processing are present
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            const text = $e.text()
            if (text.includes('new')) {
                expect(text).to.eq('\n                                                                                    new\n                                                                            ')
            }
            if (text.includes('processing')) {
                expect(text).to.eq('\n                                                processing\n                                             ')
            }

        })

        // ASSERT HOME page 2
        cy.get('#paginationDone > div > nav > div > div:nth-child(2) > span > span:nth-child(3)').contains('2').click()
        cy.url().should('contain', '/todo?page=2')

        //check the data that are in ascending order

        cy.get('#hometable > tbody > tr > td:nth-child(7)').each(($e, index, $list) => {
            if (index == 0) time_prev = 0
            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isBelow(time_prev, time, 'previous date is below actual')
            time_prev = time
        })

        //check that the data with status new and processing are present
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            const text = $e.text()
            if (text.includes('new')) {
                expect(text).to.eq('\n                                                                                    new\n                                                                            ')
            }
            if (text.includes('processing')) {
                assert.strictEqual(text, 'processing', 'processing ok ')
            }

        })

        // // //ASSERT HOME page 3
        cy.get('#paginationDone > div > nav > div > div:nth-child(2) > span > span:nth-child(4) > button').click()
        cy.url().should('contain', '/todo?page=3')

        var init = 0
        cy.get('#hometable > tbody > tr > td:nth-child(7)').each(($e, index, $list) => {
            if (index == 0) time_prev = 0
            if(time_prev < time)
            {
                time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isBelow(time_prev, time, 'previous date is below actual')
            time_prev = time

            }
            else if(time_prev > time && init == 0)
            {
            time = Math.round(new Date($e.text()).getTime() / 1000)
            assert.isAtLeast(time_prev, time, 'previous date is most actual')
            time_prev = time
            init = 1

            }

        })

        //check that the data with status new and processing are present
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            const text = $e.text()
            if (text.includes('new')) {
                expect(text).to.eq('\n                                                                                    new\n                                                                            ')
            }
            if (text.includes('processing')) {
                expect(text).to.eq('\n                                                                                    processing\n                                                                            ')
            }

        })






        //ASSERT HOME page 4
        cy.get('#paginationDone > div > nav > div > div:nth-child(2) > span > span:nth-child(5) > button').click()
        cy.url().should('contain', '/todo?page=4')

        //check the data that are in ascending order
        cy.get('#hometable > tbody > tr > td:nth-child(7)').each(($e, index, $list) => {
            if (index == 0) time_prev = 0
            if(time_prev < time)
            {
                time = Math.round(new Date($e.text()).getTime() / 1000)
                assert.isBelow(time_prev, time, 'previous date is below actual')
                time_prev = time

            }
            else if(time_prev > time && init == 0)
            {
                time = Math.round(new Date($e.text()).getTime() / 1000)
                assert.isAtLeast(time_prev, time, 'previous date is most actual')
                time_prev = time
                init = 1

            }

        })

        //check that the data with status new and processing are present
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            const text = $e.text()
            if (text.includes('new')) {
                assert.strictEqual(text, '\n                                                                                    new\n                                                                            ', 'new ok')
            }
            if (text.includes('processing')) {
                expect(text).to.eq('\n                                                                                    processing\n                                                                            ')
            }

        })
        cy.get('button.flex.text-sm.border-2.border-transparent.rounded-full').click()
        cy.get('a.block.px-4.py-2.text-sm.leading-5.text-gray-700').contains('Logout').click()



    })
})
