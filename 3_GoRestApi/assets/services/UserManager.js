import { deleteUser, fetchUsers, updateUser } from "./usersApi"

class UserManager {
    constructor() {
        this.elements = {
            search: document.querySelector(".search"),
            searchButton: document.querySelector("#searchButton"),
            table: {
                body: document.querySelector(".table-body"),
                rowTemplate: document.querySelector("#user-table-row-template").content,
            },
            modals: {
                edit: {
                    modal: document.querySelector("#editModal"),
                    cancelButton: document.querySelector("#cancelEditModal"),
                    submitButton: document.querySelector('#editModal button[type="submit"]'),
                    form: document.querySelector(".edit-form"),
                    inputs: {
                        name: document.querySelector("#name"),
                        email: document.querySelector("#email"),
                        female: document.querySelector("#female"),
                        male: document.querySelector("#male"),
                        active: document.querySelector("#active"),
                        inactive: document.querySelector("#inactive"),
                    },
                },
                delete: {
                    modal: document.querySelector("#deleteModal"),
                    cancelButton: document.querySelector("#cancelDeleteModal"),
                    submitButton: document.querySelector('#deleteModal button[type="submit"]'),
                },
            },
        }

        this.state = {
            users: [],
            currentPage: 1,
            isLoading: false,
            error: null,
        }

        this.init()
    }

    async init() {
        this.setupEventListeners()
        await this.loadUsers()
    }

    setupEventListeners() {
        this.elements.searchButton.addEventListener("click", this.handleSearchButtonClick.bind(this))

        this.elements.modals.edit.cancelButton.addEventListener("click", () => this.elements.modals.edit.modal.close())

        this.elements.modals.edit.form.addEventListener("submit", this.handleEditFormSubmit.bind(this))

        this.elements.modals.delete.cancelButton.addEventListener("click", () => this.elements.modals.delete.modal.close())

        this.elements.modals.delete.submitButton.addEventListener("click", this.handleDeleteConfirm.bind(this))
    }

    async handleSearchButtonClick() {
        const searchQuery = this.elements.search.value.trim()
        this.elements.searchButton.disabled = true
        this.elements.searchButton.innerHTML = this.createSpinner() + " Searching..."

        await this.loadUsers(searchQuery)

        this.elements.searchButton.disabled = false
        this.elements.searchButton.textContent = "Confirm"
    }

    setLoading(isLoading) {
        this.state.isLoading = isLoading

        this.elements.modals.edit.submitButton.disabled = isLoading
        this.elements.modals.delete.submitButton.disabled = isLoading

        if (isLoading) {
            this.elements.modals.edit.submitButton.innerHTML = this.createSpinner() + " Saving..."
            this.elements.modals.delete.submitButton.innerHTML = this.createSpinner() + " Deleting..."
        } else {
            this.elements.modals.edit.submitButton.textContent = "Save Changes"
            this.elements.modals.delete.submitButton.textContent = "Delete User"
        }
    }

    createSpinner() {
        return `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
  </svg>`
    }

    async loadUsers(searchQuery = "") {
        try {
            this.setLoading(true)
            this.renderLoadingState()

            const users = await fetchUsers(this.state.currentPage, searchQuery)
            this.state.users = users
            this.state.error = null

            this.renderUsers()
        } catch (error) {
            this.state.error = "Failed to load users"
            this.renderError()
        } finally {
            this.setLoading(false)
        }
    }

    /*async handleSearch(event) {
        const searchQuery = event.target.value.trim();
        await this.loadUsers(searchQuery);
    }*/

    async handleEditFormSubmit(event) {
        event.preventDefault()
        this.setLoading(true)

        const formData = new FormData(this.elements.modals.edit.form)
        const userId = this.elements.modals.edit.form.dataset.id

        const userData = {
            name: formData.get("name"),
            email: formData.get("email"),
            gender: formData.get("gender"),
            status: formData.get("status"),
        }

        try {
            const response = await updateUser(userId, userData)

            if (response.success) {
                await this.loadUsers()
                this.elements.modals.edit.modal.close()
            } else {
                console.error(response.error)
            }
        } catch (error) {
            console.error("Failed to update user", error)
        } finally {
            this.setLoading(false)
        }
    }

    async handleDeleteConfirm(event) {
        event.preventDefault()
        this.setLoading(true)

        const userId = this.elements.modals.delete.modal.dataset.id

        try {
            const response = await deleteUser(userId)

            if (response.success) {
                await this.loadUsers()
                this.elements.modals.delete.modal.close()
            } else {
                console.error(response.error)
            }
        } catch (error) {
            console.error("Failed to delete user", error)
        } finally {
            this.setLoading(false)
        }
    }

    showEditModal(user) {
        this.prefillEditForm(user)
        this.elements.modals.edit.modal.showModal()
    }

    showDeleteModal(user) {
        this.elements.modals.delete.modal.dataset.id = user.id
        this.elements.modals.delete.modal.showModal()
    }

    prefillEditForm(user) {
        if (!user) return

        const inputs = this.elements.modals.edit.inputs

        inputs.name.value = user.name || ""
        inputs.email.value = user.email || ""
        inputs.female.checked = user.gender === "female"
        inputs.male.checked = user.gender === "male"
        inputs.active.checked = user.status === "active"
        inputs.inactive.checked = user.status === "inactive"

        this.elements.modals.edit.form.dataset.id = user.id
    }

    renderUsers() {
        this.elements.table.body.innerHTML = ""
        if (this.state.users.length === 0) {
            this.elements.table.body.innerHTML = '<tr><td colspan="5" class="text-center py-4">No users found</td></tr>'
            return
        }

        this.state.users.forEach((user) => {
            const row = this.createTableRow(user)
            this.elements.table.body.appendChild(row)
        })
    }

    renderLoadingState() {
        this.elements.table.body.innerHTML = `
    <tr>
      <td colspan="5" class="text-center py-8">
        <div class="flex justify-center">
          <svg class="animate-spin h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
        </div>
      </td>
    </tr>
  `
    }

    renderError() {
        this.elements.table.body.innerHTML = `
    <tr>
      <td colspan="5" class="text-center text-red-500 py-4">
        <div class="flex flex-col items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
          ${this.state.error}
        </div>
        <button class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" onclick="userManager.loadUsers()">
          Try Again
        </button>
      </td>
    </tr>
  `
    }

    createTableRow(user) {
        const rowFragment = this.elements.table.rowTemplate.cloneNode(true)
        const row = rowFragment.querySelector("tr")

        row.dataset.id = user.id
        row.querySelector(".name").textContent = user.name ?? ""
        row.querySelector(".email").textContent = user.email ?? ""
        row.querySelector(".gender").textContent = user.gender ?? ""
        row.querySelector(".status").textContent = user.status ?? ""

        row.querySelector(".edit").addEventListener("click", () => this.showEditModal(user))
        row.querySelector(".delete").addEventListener("click", () => this.showDeleteModal(user))

        return row
    }
}

const userManager = new UserManager()

