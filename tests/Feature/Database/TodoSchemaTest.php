<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TodoSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_todo_schema_tables_and_columns_are_available(): void
    {
        $this->assertTrue(Schema::hasColumns('users', [
            'avatar',
            'theme_preference',
        ]));

        $this->assertTrue(Schema::hasColumns('categories', [
            'id',
            'user_id',
            'name',
            'color',
            'icon',
            'created_at',
            'updated_at',
        ]));

        $this->assertTrue(Schema::hasColumns('tasks', [
            'id',
            'user_id',
            'title',
            'description',
            'priority',
            'status',
            'due_date',
            'reminder_at',
            'position',
            'created_at',
            'updated_at',
            'deleted_at',
        ]));

        $this->assertTrue(Schema::hasColumns('subtasks', [
            'id',
            'task_id',
            'title',
            'is_completed',
            'position',
            'created_at',
            'updated_at',
        ]));

        $this->assertTrue(Schema::hasColumns('tags', [
            'id',
            'user_id',
            'name',
            'color',
            'created_at',
            'updated_at',
        ]));

        $this->assertTrue(Schema::hasColumns('task_category', [
            'task_id',
            'category_id',
        ]));

        $this->assertTrue(Schema::hasColumns('task_tag', [
            'task_id',
            'tag_id',
        ]));

        $this->assertTrue(Schema::hasColumns('attachments', [
            'id',
            'task_id',
            'file_path',
            'file_name',
            'file_type',
            'file_size',
            'created_at',
            'updated_at',
        ]));
    }

    public function test_todo_schema_foreign_keys_use_cascade_on_delete(): void
    {
        $this->assertCascadeForeignKey('categories', 'user_id', 'users');
        $this->assertCascadeForeignKey('tasks', 'user_id', 'users');
        $this->assertCascadeForeignKey('subtasks', 'task_id', 'tasks');
        $this->assertCascadeForeignKey('tags', 'user_id', 'users');
        $this->assertCascadeForeignKey('task_category', 'task_id', 'tasks');
        $this->assertCascadeForeignKey('task_category', 'category_id', 'categories');
        $this->assertCascadeForeignKey('task_tag', 'task_id', 'tasks');
        $this->assertCascadeForeignKey('task_tag', 'tag_id', 'tags');
        $this->assertCascadeForeignKey('attachments', 'task_id', 'tasks');
    }

    private function assertCascadeForeignKey(string $table, string $column, string $foreignTable): void
    {
        $foreignKey = collect(Schema::getForeignKeys($table))
            ->first(fn (array $key): bool => $key['columns'] === [$column] && $key['foreign_table'] === $foreignTable);

        $this->assertNotNull($foreignKey, sprintf(
            'Failed asserting that %s.%s references %s.',
            $table,
            $column,
            $foreignTable,
        ));

        $this->assertSame('cascade', $foreignKey['on_delete']);
    }
}
