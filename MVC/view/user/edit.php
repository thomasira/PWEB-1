
<main>
    <header>
        <h2>Edit User</h2>
    </header>
    <section>
        <form action="{{ path }}user/update" method="post">
            <label>Name
                <input type="text" name="name" value="{{ user.name }}" required>
                <span class="error">{{ errors.name }}</span>
            </label>
            <label>Address
                <input type="text" name="address" value="{{ user.address }}">
                <span class="error">{{ errors.address }}</span>
            </label>
            <input type="hidden" name="id" value="{{ user.id }}">
            <input type="submit" value="update" class="button">
        </form>
    </section>
</main>