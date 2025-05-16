        <div class="hidden md:block w-64 bg-white border-r border-gray-200 overflow-y-auto">
            <div class="p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Members</h3>
                <ul class="space-y-2">
                    <!-- MEMBER_LIST_START -->
                    <li class="flex items-center space-x-3 rtl:space-x-reverse">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium">
                                {{MEMBER_INITIAL}}
                            </div>
                        </div>
                        <div class="text-sm font-medium text-gray-900">
                            {{MEMBER_NAME}}
                            <!-- CREATOR_INDICATOR_START -->
                            <span class="ml-2 text-xs text-blue-600">(Creator)</span>
                            <!-- CREATOR_INDICATOR_END -->
                        </div>
                    </li>
                    <!-- MEMBER_LIST_END -->
                </ul>
            </div>

            <!-- Invite Members Form -->
            <div class="p-4 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Invite Members</h3>
                <form action="{{INVITE_FORM_ACTION}}" method="POST" class="space-y-3">
                    {{CSRF_FIELD}}
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Select User</label>
                        <select name="user_id" id="user_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Select a user</option>
                            <!-- AVAILABLE_USER_LIST_START -->
                            <option value="{{USER_ID}}">{{USER_NAME}}</option>
                            <!-- AVAILABLE_USER_LIST_END -->
                        </select>
                    </div>
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Invite
                        </button>
                    </div>
                </form>
            </div>
        </div>
