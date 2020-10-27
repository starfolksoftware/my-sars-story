<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasApprovalFlow {
  /**
   * Get the user relationship.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function editor(): BelongsTo
  {
    return $this->belongsTo(\App\Models\Auth\User::class, 'editor_id');
  }

  /**
   * Get the user relationship.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function approvedBy(): BelongsTo
  {
    return $this->belongsTo(\App\Models\Auth\User::class, 'approved_by');
  }

  /**
   * Check to see if the post is published.
   *
   * @return bool
   */
  public function getPublishedAttribute(): bool
  {
    return ! is_null($this->published_at) && $this->published_at <= now()->toDateTimeString();
  }

  /**
   * Check to see if the post is submitted for approval.
   *
   * @return bool
   */
  public function getSubmittedAttribute(): bool
  {
    return ! is_null($this->submitted_at) && $this->submitted_at <= now()->toDateTimeString();
  }

  /**
   * Check to see if the post is approved.
   *
   * @return bool
   */
  public function getApprovedAttribute(): bool
  {
    return ! is_null($this->approved_at) && $this->approved_at <= now()->toDateTimeString();
  }

  /**
   * Scope a query to only include published posts.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopePublished($query): Builder
  {
    return $query->where([
      ['submitted_at', '<=', now()->toDateTimeString()],
      ['approved_at', '<=', now()->toDateTimeString()],
      ['published_at', '<=', now()->toDateTimeString()]
    ]);
  }

  /**
   * Scope a query to only include posts submitted for approval.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeSubmitted($query): Builder
  {
    return $query->where([
      ['submitted_at', '<=', now()->toDateTimeString()],
      ['approved_at', '=', NULL],
      ['published_at', '=', NULL]
    ]);
  }

  /**
   * Scope a query to only include approved posts.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeApproved($query): Builder
  {
    return $query->where([
      ['submitted_at', '<=', now()->toDateTimeString()],
      ['approved_at', '<=', now()->toDateTimeString()],
      ['published_at', '=', NULL]
    ]);
  }

  /**
   * Scope a query to only include drafted posts.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeDraft($query): Builder
  {
    return $query->where([
      ['submitted_at', '=', NULL],
      ['approved_at', '=', NULL],
      ['published_at', '=', NULL]
    ])->orWhere([
      ['submitted_at', '>', now()->toDateTimeString()],
      ['approved_at', '>', now()->toDateTimeString()],
      ['published_at', '>', now()->toDateTimeString()]
    ]);
  }

  /**
   * Scope a query to only include posts for the current logged in user.
   *
   * @param Builder $query
   * @return Builder
   */
  public function scopeForCurrentUser($query): Builder
  {
    return $query->where('user_id', request()->user()->id ?? null);
  }
}