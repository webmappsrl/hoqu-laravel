describe('Bulk Reschedule Todo', () => {
    //FASE LOGIN
    const email = 'team@webmapp.it'
    const password = 'webmapp'

    it('Bulk Reschedule Todo', () => {
        cy.visit('/login')
        const a = 'team';
        cy.get('input[name=email]').type(email)
        cy.get('input[name=password]').type(password)
        cy.get('button').contains('Login').click()

        //ASSERT HOME BASE
        cy.url().should('contain', '/')
        cy.get('body > div > main > div > div > div > header > div:nth-child(1) > button').click()

        cy.get('span#link_todo').click()

        //ASSERT error
        cy.url().should('contain', '/todo')


        //Check Resk
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(2)').invoke('text').then((text1) => {

            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1) > label > input').click()

            cy.get('#hometable > tbody > tr:nth-child(2) > td:nth-child(2)').invoke('text').then((text2) => {

                cy.get('#hometable > tbody > tr:nth-child(2) > td:nth-child(1) > label > input').click()
                cy.get('button#bulkRes').click()
                cy.contains('Cancel').click()

                cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(2)').invoke('text').should((text3) => {
                    expect(text1).to.eq(text3)
                })
                cy.get('#hometable > tbody > tr:nth-child(2) > td:nth-child(2)').invoke('text').should((text4) => {
                    expect(text2).to.eq(text4)
                })

                cy.get('button#bulkRes').click()
                cy.get('button#buttonBulkRes').click()

                cy.get('body > div > main > div > div > div > main > div > div > div > div > div> div > div > p').invoke('text').then((text) => {
                    var id = text.split(' ')[5]
                    cy.log(id)
                    var id1 = text.split(' ')[13]
                    cy.log(id1)
                    cy.log(text1)
                    expect(text2).to.eq(                    '\n                                        \n                                            ' + id1 + '\n                                        \n                                    ')
                    expect(text1).to.eq(                    '\n                                        \n                                            ' + id + '\n                                        \n                                    ')

                })

            })
        })

        //Check Skip
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(2)').invoke('text').then((text1) => {

            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1) > label > input').click()

            cy.get('#hometable > tbody > tr:nth-child(2) > td:nth-child(2)').invoke('text').then((text2) => {

                cy.get('#hometable > tbody > tr:nth-child(2) > td:nth-child(1) > label > input').click()
                cy.get('button#bulkSkip').click()
                cy.contains('Cancel').click()

                cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(2)').invoke('text').should((text3) => {
                    expect(text1).to.eq(text3)
                })
                cy.get('#hometable > tbody > tr:nth-child(2) > td:nth-child(2)').invoke('text').should((text4) => {
                    expect(text2).to.eq(text4)
                })

                cy.get('button#bulkSkip').click()
                cy.get('button#buttonBulkSkip').click()

                cy.get('body > div > main > div > div > div > main > div > div > div > div > div> div > div > p').invoke('text').then((text) => {
                    var id2 = text.split(' ')[5]
                    cy.log(id2)
                    var id3 = text.split(' ')[13]
                    cy.log(id3)

                    expect(text1).to.eq('\n                                        \n                                            ' + id2 + '\n                                        \n                                    ')
                    expect(text2).to.eq('\n                                        \n                                            ' + id3 + '\n                                        \n                                    ')

                })

            })
        })

        cy.get('button.flex.text-sm.border-2.border-transparent.rounded-full').click()
        cy.get('a.block.px-4.py-2.text-sm.leading-5.text-gray-700').contains('Logout').click()

    })
})
