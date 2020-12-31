
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

        //ASSERT todo
        cy.url().should('contain', '/todo')

        //Check Cancel Button Res
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').then((text1) => {

            cy.get('button#buttonTodoRes0').click()
            cy.contains('Cancel').click()

            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').should((text2) => {
              expect(text1).to.eq(text2)
            })
        })

        //Check Cancel Button Skip
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').then((text1) => {

            cy.get('button#buttonTodoSkip0').click()
            cy.contains('Cancel').click()

            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').should((text2) => {
                expect(text1).to.eq(text2)
            })
        })

        // Check Reschedule Button Skip
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').then((text1) => {

            cy.get('button#buttonTodoSkip0').click()
            cy.contains('Skip').click()
            cy.log(text1)
            // cy.wait(5000)


            //id via notification
            cy.get('body > div > main > div > div > div > main > div > div > div > div > div> div > div > p').invoke('text').then((text) => {
                // cy.log(text)


                var id = text.split(' ')[5]

                cy.log(id)
                  expect(text1).to.eq('\n                                        \n                                            '+id+'\n                                        \n                                    ')

                cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').then((text2) => {

                    cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').should((text3) => {
                        expect(text1).to.not.eq(text3)
                    })
                })



        })




        })

    })
})
