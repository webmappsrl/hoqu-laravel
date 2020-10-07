
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

        cy.get('span#link_error').click()

        //ASSERT archive
        cy.url().should('contain', '/error')


        const id1 = cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)')
        cy.get('#hometable > tbody > tr:nth-child(1) > td.border.px-4.py-2 > button').click()
        cy.get('#buttonChange > span.flex.w-full.rounded-md.shadow-sm.sm\:ml-3.sm\:w-auto > button').click()








        cy.get('button.flex.text-sm.border-2.border-transparent.rounded-full').click()
        cy.get('a.block.px-4.py-2.text-sm.leading-5.text-gray-700').contains('Logout').click()



    })
})
