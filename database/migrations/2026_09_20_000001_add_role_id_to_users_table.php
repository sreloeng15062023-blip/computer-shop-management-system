<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Add Role ID to Users Table
 * 
 * Purpose:
 * Connects the 'users' table to the 'roles' table using a foreign key constraint.
 * This enables Role-Based Access Control (RBAC) across the entire system, allowing
 * us to assign roles like Admin, Manager, Sale Staff, Cashier, and Technician.
 */
class AddRoleIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds the 'role_id' column to the 'users' table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add 'role_id' as an unsigned big integer (matching roles.id)
            // nullable(): Allows creating users before assigning a role if necessary
            // after('id'): Places this column right after 'id' for clean table schema
            // constrained('roles'): Sets up a foreign key pointing to 'id' on the 'roles' table
            // nullOnDelete(): If a role is deleted, set user's role_id to NULL instead of breaking records
            $table->foreignId('role_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('roles')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * Drops the foreign key constraint and removes the 'role_id' column.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key constraint first to avoid SQL constraint violations
            $table->dropForeign(['role_id']);
            // Drop the column from the users table
            $table->dropColumn('role_id');
        });
    }
}
