import { z } from 'zod';

export const submissionSchema = z.object({
  type: z.enum(['evidence', 'correction', 'additional_source', 'technical_observation']),
  title: z.string().trim().min(8, 'Use at least 8 characters.').max(120),
  description: z.string().trim().min(40, 'Provide enough context for editorial review.').max(5000),
  relatedObjectId: z.string().trim().optional(),
});

export type SubmissionInput = z.infer<typeof submissionSchema>;
