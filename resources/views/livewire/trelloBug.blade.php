<div id="skipModal"class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <!-- Information Modal -->
            <div class="flex justify-between border-b border-gray-100 px-5 py-4">
                <div>
                    <i class="fa fa-exclamation-triangle text-orange-500"></i>
                    <span class="font-bold text-gray-700 text-lg">Create Card Trello Back Log</span>
                </div>
                <div>
                    <button wire:click="closeModalTrelloBug()"><i class="fa fa-times-circle text-red-500 hover:text-red-600 transition duration-150"></i></button>
                </div>
            </div>

            <div class="px-10 py-5 text-gray-600">
                <label  wire:model="Task_id" for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2 text-center">you are creating a trello card related to the task {{$Task_id}}</label>
                <p class="text-lg text-center"></p>
                <div class="flex flex-col mb-6">
                    <label for="exampleFormControlInput2" class="block text-center text-gray-700 text-sm font-bold mb-2 ">select a developer.</label>

                <select id="TrelloMember" class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none" name="trelloMember" class="border shadow p-2 bg-white" wire:model='trelloMember'>
                    <option value=''>Developer</option>
                    <option id="dvdpzzt" value='@dvdpzzt'>Davide Pizzato</option>
                    <option id="pedramkat" value='@pedramkat'>Pedram Katanchi</option>
                    <option id="gianmarcogagliardi1" value='@gianmarcogagliardi1'>Gianmarco Gagliardi</option>
                </select >
                @error('TrelloMember') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>

            </div>


            <div id="buttonChange" class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button wire:click.prevent="sendCardBackLog()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
            Create Card BL
            </button>
            </span>
                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <button id="buttonCancel" wire:click="closeModalTrelloBug()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
            Cancel
            </button>
            </span>
                </form>
            </div>
        </div>
    </div>
</div>
</div>


