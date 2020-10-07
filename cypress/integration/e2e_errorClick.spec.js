
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

            cy.get('#hometable > tbody > tr:nth-child(1) > td.border.px-4.py-2 > button').click()
            cy.contains('Cancel').click()

            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').should((text2) => {
              expect(text1).to.eq(text2)
            })
        })

        //Check Reschedule Button
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').then((text1) => {

            cy.get('#hometable > tbody > tr:nth-child(1) > td.border.px-4.py-2 > button').click()
            cy.contains('Change').click()

            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').should((text2) => {
              expect(text1).not.to.eq(text2)
            })
            cy.visit('/'+text1+"/show")
            cy.url().should('contain', '/'+text1+"/show")
            cy.get('#processStatus').each(($e, index, $list) => {
                const text = $e.text()
                expect(text).to.contain('\n                                 Status: new\n                              ')

            })
        })
         cy.get('button.flex.text-sm.border-2.border-transparent.rounded-full').click()
         cy.get('a.block.px-4.py-2.text-sm.leading-5.text-gray-700').contains('Logout').click()

    })
})
