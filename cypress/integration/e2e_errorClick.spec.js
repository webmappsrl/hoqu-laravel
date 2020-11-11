
describe('Registration', () => {
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

        cy.get('span#link_error').click()

        //ASSERT error
        cy.url().should('contain', '/error')

        //Check Cancel Button
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').then((text1) => {

            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(9) > div > button > span').click()
            cy.contains('Cancel').click()

            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').should((text2) => {
              expect(text1).to.eq(text2)
            })
        })

        //Check Reschedule Button Skip
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').then((text1) => {

            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(9) > div > button > span').click()
            cy.contains('Reschedule').click()

            // cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').should((text2) => {
            //     expect(text1).not.to.eq(text2)
            // })
            cy.visit('/'+text1+"/show")
            cy.get('h4#processStatus').each(($e, index, $list) => {
                const text = $e.text()
                expect(text).to.contain('new')

            })
        })

    })
})
