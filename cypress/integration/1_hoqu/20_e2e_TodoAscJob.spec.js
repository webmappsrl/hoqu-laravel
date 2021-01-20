
describe('Filter in Todo', () => {
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


        cy.get('#paginationDone > div > nav > div.hidden.sm\\:flex-1.sm\\:flex.sm\\:items-center.sm\\:justify-between > div:nth-child(1) > p > span:nth-child(4)').invoke('text').then((d_id) => {
            expect(d_id).to.contain(50)
        })

        cy.get('select#pageNumber').select('10')

        cy.get('#p10').invoke('text').then((d_id) => {
            cy.wait(1000)
            cy.get('#paginationDone > div > nav > div.hidden.sm\\:flex-1.sm\\:flex.sm\\:items-center.sm\\:justify-between > div:nth-child(1) > p > span:nth-child(4)').invoke('text').then((num) => {
                expect(num).to.contain(d_id)
            })
        })

        cy.get('select#pageNumber').select('25')

        cy.get('#p25').invoke('text').then((d_id) => {
            cy.wait(1000)
            cy.get('#paginationDone > div > nav > div.hidden.sm\\:flex-1.sm\\:flex.sm\\:items-center.sm\\:justify-between > div:nth-child(1) > p > span:nth-child(4)').invoke('text').then((num) => {
                expect(num).to.contain(d_id)
            })
        })

        cy.get('select#pageNumber').select('50')

        cy.get('#p50').invoke('text').then((d_id) => {
            cy.wait(1000)
            cy.get('#paginationDone > div > nav > div.hidden.sm\\:flex-1.sm\\:flex.sm\\:items-center.sm\\:justify-between > div:nth-child(1) > p > span:nth-child(4)').invoke('text').then((num) => {
                expect(num).to.contain(d_id)
            })
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

            cy.get('select#selectJob').select('Et.')
            cy.wait(1000)
            cy.get('#hometable > tbody > tr > td:nth-child(4)').each(($e, index, $list) => {
                expect($e.text()).to.contain('Et.')
            })
            cy.get('#hometable > tbody > tr > td:nth-child(7)').each(($e, index, $list) => {
                if (index == 0){time_prev=0}
                expect(Cypress.moment($e.text()).isAfter(Cypress.moment(time_prev))).to.be.true;
                time_prev = time

            })

            cy.get('select#dataAsc').select('asc')
            cy.wait(1000)
            cy.get('#hometable > tbody > tr > td:nth-child(4)').each(($e, index, $list) => {
                expect($e.text()).to.contain('Et.')
            })
            cy.get('#hometable > tbody > tr > td:nth-child(7)').each(($e, index, $list) => {
                if (index == 0)time_prev=0
                time = Math.round(new Date($e.text()).getTime() / 1000)
                assert.isBelow(time_prev, time, 'previous date is below actual')
                time_prev = time
            })

            cy.get('select#selectInstance').select('montepisano.org')
            cy.wait(1000)
            cy.get('#hometable > tbody > tr > td:nth-child(3)').each(($e, index, $list) => {
                expect($e.text()).to.contain('montepisano.org')
            })
            cy.get('#hometable > tbody > tr > td:nth-child(4)').each(($e, index, $list) => {
                expect($e.text()).to.contain('Et.')
            })
            cy.get('#hometable > tbody > tr > td:nth-child(7)').each(($e, index, $list) => {
                if (index == 0)time_prev=0
                time = Math.round(new Date($e.text()).getTime() / 1000)
                assert.isBelow(time_prev, time, 'previous date is below actual')
                time_prev = time
            })
            cy.get('select#dataAsc').select('desc')
            cy.wait(1000)

            cy.get('#hometable > tbody > tr > td:nth-child(7)').each(($e, index, $list) => {
                if (index == 0){time_prev=0}
                expect(Cypress.moment($e.text()).isAfter(Cypress.moment(time_prev))).to.be.true;
                time_prev = time

            })

        })
        cy.get('select#pageNumber').select('100')
        cy.get('select#selectInstance').select('Choose a Instance')
        cy.get('select#selectJob').select('Choose a job')



        cy.get('#p100').invoke('text').then((d_id) => {
            cy.wait(1000)
            cy.get('#paginationDone > div > nav > div.hidden.sm\\:flex-1.sm\\:flex.sm\\:items-center.sm\\:justify-between > div:nth-child(1) > p > span:nth-child(4)').invoke('text').then((num) => {
                expect(num).to.contain(d_id)
            })
        })

        cy.get('select#selectProcessStatus').select('processing')
        cy.wait(1000)
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            const text = $e.text()

                expect(text).to.eq('\n                                                                                    processing\n                                                                            ')

        })

        cy.get('select#selectProcessStatus').select('new')
        cy.wait(1000)
        cy.get('#hometable > tbody > tr > td:nth-child(6)').each(($e, index, $list) => {
            const text = $e.text()

            expect(text).to.eq('\n                                                                                    new\n                                                                            ')

        })
        cy.get('button.flex.text-sm.border-2.border-transparent.rounded-full').click()
        cy.get('a.block.px-4.py-2.text-sm.leading-5.text-gray-700').contains('Logout').click()

    })
})
