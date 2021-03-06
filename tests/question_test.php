<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Unit tests for the varnumericset question definition class.
 *
 * @package   qtype_varnumericset
 * @copyright 2012 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
global $CFG;

require_once($CFG->dirroot . '/question/type/varnumericset/question.php');
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');


/**
 * Unit tests for the varnumericset question definition class.
 *
 * @copyright 2012 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @group qtype_varnumericset
 */
class qtype_varnumericset_question_test extends advanced_testcase {
    public function test_num_within_allowed_error() {
        $this->assertTrue(
                qtype_varnumericset_question::num_within_allowed_error('1.230001e4', 1.23e4, ''));
        $this->assertFalse(
                qtype_varnumericset_question::num_within_allowed_error('1.230002e4', 1.23e4, ''));
        $this->assertTrue(
                qtype_varnumericset_question::num_within_allowed_error('-1.230001e4', -1.23e4, ''));
        $this->assertFalse(
                qtype_varnumericset_question::num_within_allowed_error('-1.230002e4', -1.23e4, ''));
        $this->assertTrue(
                qtype_varnumericset_question::num_within_allowed_error('-9.000009e-4', -9e-4, ''));
        $this->assertFalse(
                qtype_varnumericset_question::num_within_allowed_error('-9.000010e-4', -9e-4, ''));
        $this->assertTrue(
                qtype_varnumericset_question::num_within_allowed_error('1.2301e4', 1.23e4, '1'));
        $this->assertFalse(
                qtype_varnumericset_question::num_within_allowed_error('1.23015e4', 1.23e4, '1'));
        $this->assertTrue(
                qtype_varnumericset_question::num_within_allowed_error('12299', 1.23e4, '1'));
        $this->assertFalse(
                qtype_varnumericset_question::num_within_allowed_error('1.2985e4', 1.23e4, '1'));
        $this->assertTrue(
                qtype_varnumericset_question::num_within_allowed_error('1.2299', 1.23, '0.001'));
        $this->assertFalse(
                qtype_varnumericset_question::num_within_allowed_error('1.2985', 1.23, '0.001'));
        $this->assertTrue(
                qtype_varnumericset_question::num_within_allowed_error('-12299', -1.23e4, '1'));
        $this->assertFalse(
                qtype_varnumericset_question::num_within_allowed_error('-1.2985e4', -1.23e4, '1'));
        $this->assertTrue(
                qtype_varnumericset_question::num_within_allowed_error('-1.2299', -1.23, '0.001'));
        $this->assertFalse(
                qtype_varnumericset_question::num_within_allowed_error('-1.2985', -1.23, '0.001'));
        $this->assertTrue(
                qtype_varnumericset_question::num_within_allowed_error('12301', 1.23e4, '1'));
        $this->assertFalse(
                qtype_varnumericset_question::num_within_allowed_error('12301.5', 1.23e4, '1'));
        $this->assertTrue(
                qtype_varnumericset_question::num_within_allowed_error('-4', -4, ''));
        $this->assertFalse(
                qtype_varnumericset_question::num_within_allowed_error('4', -4, ''));
        $this->assertTrue(
                qtype_varnumericset_question::num_within_allowed_error('-4', -4, '0.0001'));
        $this->assertFalse(
                qtype_varnumericset_question::num_within_allowed_error('4', -4, '0.0001'));
    }

    public function test_wrong_by_a_factor_of_ten() {
        $this->assertTrue(
            qtype_varnumericset_question::wrong_by_a_factor_of_ten('1.23e4', 1.23e5, '', 1));
        $this->assertFalse(
            qtype_varnumericset_question::wrong_by_a_factor_of_ten('1.23e4', 1.23e6, '', 1));
        $this->assertTrue(
            qtype_varnumericset_question::wrong_by_a_factor_of_ten('1.231', 12.3, 0.01, 1));
        $this->assertFalse(
            qtype_varnumericset_question::wrong_by_a_factor_of_ten('1.232', 12.3, 0.01, 1));
        $this->assertTrue(
            qtype_varnumericset_question::wrong_by_a_factor_of_ten('151000', 150, 1, 3));
        $this->assertFalse(
            qtype_varnumericset_question::wrong_by_a_factor_of_ten('152000', 150, 1, 3));
    }

    public function test_has_number_of_sig_figs() {
        $this->assertTrue(
            qtype_varnumericset_question::has_number_of_sig_figs('1.23e4', 3));
        $this->assertTrue(
            qtype_varnumericset_question::has_number_of_sig_figs('1.23456e4', 6));
         $this->assertFalse(
            qtype_varnumericset_question::has_number_of_sig_figs('1.2345e4', 6));
        $this->assertTrue(
            qtype_varnumericset_question::has_number_of_sig_figs('1.231', 4));
        $this->assertFalse(
            qtype_varnumericset_question::has_number_of_sig_figs('1.231', 3));
        $this->assertTrue(
            qtype_varnumericset_question::has_number_of_sig_figs('1232', 4));
        $this->assertTrue(
            qtype_varnumericset_question::has_number_of_sig_figs('1230', 3));
        $this->assertFalse(
            qtype_varnumericset_question::has_number_of_sig_figs('1232', 3));
        $this->assertTrue(
            qtype_varnumericset_question::has_number_of_sig_figs('151000', 3));
        $this->assertFalse(
            qtype_varnumericset_question::has_number_of_sig_figs('152000', 2));
    }

    public function test_has_too_many_sig_figs() {
        $this->assertTrue(qtype_varnumericset_question::has_too_many_sig_figs('1.23456e5', 123456, 2));;
        $this->assertTrue(qtype_varnumericset_question::has_too_many_sig_figs('1.23456e5', 123456, 3));;
        $this->assertTrue(qtype_varnumericset_question::has_too_many_sig_figs('1.23456e5', 123456, 4));;
        $this->assertTrue(qtype_varnumericset_question::has_too_many_sig_figs('1.23456e5', 123456, 5));;
        $this->assertFalse(qtype_varnumericset_question::has_too_many_sig_figs('1.23456e5', 123456, 6));;
        $this->assertTrue(qtype_varnumericset_question::has_too_many_sig_figs('1.234560e5', 123456, 6));;
        $this->assertFalse(qtype_varnumericset_question::has_too_many_sig_figs('1.23456e5', 123456, 6));;
        // Should only return true when extra sig figs in response are correct.
        $this->assertTrue(
            qtype_varnumericset_question::has_too_many_sig_figs('1.23456', 1.23456, 2));
        $this->assertTrue(
            qtype_varnumericset_question::has_too_many_sig_figs('1.2346', 1.23456, 2));
        $this->assertFalse(
            qtype_varnumericset_question::has_too_many_sig_figs('1.2345', 1.23456, 2));
        $this->assertTrue(
            qtype_varnumericset_question::has_too_many_sig_figs('1.23', 1.23456, 2));
        $this->assertFalse(
            qtype_varnumericset_question::has_too_many_sig_figs('1.24', 1.23456, 2));
        $this->assertFalse(
            qtype_varnumericset_question::has_too_many_sig_figs('1.23457', 1.23456, 2));
        $this->assertTrue(
            qtype_varnumericset_question::has_too_many_sig_figs('1.23456e4', 1.23456e4, 2));
        $this->assertFalse(
            qtype_varnumericset_question::has_too_many_sig_figs('1.23456e4', 1.33456e4, 2));
        $this->assertTrue(
            qtype_varnumericset_question::has_too_many_sig_figs('7.89e-4', 7.890123e-4, 2));
        $this->assertFalse(
            qtype_varnumericset_question::has_too_many_sig_figs('-1.23456e-12', -1.2346e-12, 4));
        $this->assertFalse(
            qtype_varnumericset_question::has_too_many_sig_figs('7.89e-4', 7.89e-4, 3));
        $this->assertTrue(
            qtype_varnumericset_question::has_too_many_sig_figs('7.891e-4', 7.891e-4, 3));
        $this->assertTrue(
            qtype_varnumericset_question::has_too_many_sig_figs('7.891e-4', 789.10e-6, 3));
        $this->assertTrue(
            qtype_varnumericset_question::has_too_many_sig_figs('7.891e-4', 007.891e-4, 3));
        $this->assertFalse(
            qtype_varnumericset_question::has_too_many_sig_figs('-1.23456e-12', -1.2346e-12, 4));
    }

    public function test_rounding_incorrect() {
        $this->assertTrue(
            qtype_varnumericset_question::rounding_incorrect('1.234', 1.2345, 4));
        $this->assertTrue(
            qtype_varnumericset_question::rounding_incorrect('1.2345', 1.23456, 5));
        // This routine is not meant to catch incorrect rounding up.
        $this->assertFalse(
            qtype_varnumericset_question::rounding_incorrect('1.3', 1.23, 2));
        $this->assertFalse(
            qtype_varnumericset_question::rounding_incorrect('1.23', 1.23456, 2));

    }

    public function test_round_to() {
        $this->assertSame('0.123', qtype_varnumericset_question::round_to(0.12345, 3, false));
        $this->assertSame('0.1235', qtype_varnumericset_question::round_to(0.12345, 4, false));
        // Incorrect rounding.
        $this->assertSame('1.235e-1',
                                        qtype_varnumericset_question::round_to(0.12345, 4, true));
        // Incorrect rounding.
        $this->assertSame('1.234e-1',
                                    qtype_varnumericset_question::round_to(0.12345, 4, true, true));
        $this->assertSame('1234.57',
                                    qtype_varnumericset_question::round_to(1234.5678, 6, false));
        $this->assertSame('1.23457e3',
                                    qtype_varnumericset_question::round_to(1234.5678, 6, true));
        // Incorrect rounding.
        $this->assertSame('1234.56',
                                qtype_varnumericset_question::round_to(1234.5678, 6, false, true));
        $this->assertSame('1.23456e3',
                                qtype_varnumericset_question::round_to(1234.5678, 6, true, true));
        // Always round down when incorrect rounding requested.
        $this->assertSame('1234.56',
                                qtype_varnumericset_question::round_to(1234.5600, 6, false, true));
        $this->assertSame('1.23456e3',
                                qtype_varnumericset_question::round_to(1234.5600, 6, true, true));
    }

    protected function grade($question, $enteredresponse) {
        list($fraction, $stateforfraction) = $question->grade_response(array('answer'=>$enteredresponse));
        return $fraction;
    }

    public function test_grade_response() {
        $question = test_question_maker::make_question('varnumericset', 'no_accepted_error');
        $this->assertEquals($this->grade($question, '-4.2'), 1);
        $this->assertEquals($this->grade($question, '4.2'), 0);

        $question = test_question_maker::make_question('varnumericset', 'numeric_accepted_error');
        $this->assertEquals($this->grade($question, '-4.2'), 1);
        $this->assertEquals($this->grade($question, '4.2'), 0);

        $question = test_question_maker::make_question('varnumericset', '3_sig_figs');
        $this->assertEquals($this->grade($question, '12300'), 1);
        $this->assertEquals($this->grade($question, '0012300'), 1);
        $this->assertEquals($this->grade($question, '123e2'), 1);
        $this->assertEquals($this->grade($question, '00123e2'), 1);
        $this->assertEquals($this->grade($question, '12.3e3'), 1);
        $this->assertEquals($this->grade($question, '1.23e4'), 1);
        $this->assertEquals($this->grade($question, '0.123e5'), 1);
        $this->assertEquals($this->grade($question, '0.0123e6'), 1);
        $this->assertEquals($this->grade($question, '0.000123e8'), 1);
        $this->assertEquals($this->grade($question, '123450e-1'), 0.9);
        $this->assertEquals($this->grade($question, '123450000e-4'), 0.9);
        $this->assertEquals($this->grade($question, '123450000e-3'), 0);
        $this->assertEquals($this->grade($question, '001235e1'), 0.9); // Correct to wrong amount of sig figs.
        $this->assertEquals($this->grade($question, '001234e1'), 0.0); // Incorrect rounding.
        $this->assertEquals($this->grade($question, '1235e1'),   0.9); // Correct to wrong amount of sig figs.
        $this->assertEquals($this->grade($question, '123.5e2'),  0.9); // Correct to wrong amount of sig figs.
        $this->assertEquals($this->grade($question, '0012345'),  0.9); // Correct to wrong amount of sig figs.
        $this->assertEquals($this->grade($question, '12350'),    0.9); // Correct to wrong amount of sig figs.
        $this->assertEquals($this->grade($question, '12345'),    0.9); // Correct to wrong amount of sig figs.

        $question = test_question_maker::make_question('varnumericset', '3_sig_figs_2');
        $this->assertEquals($this->grade($question, '1.23'),   1);
        $this->assertEquals($this->grade($question, '01.23'),  1);
        $this->assertEquals($this->grade($question, '1.230'),  0);   // Wrong.
        $this->assertEquals($this->grade($question, '1.235'),  0.9); // Wrong no of sig figs.
        $this->assertEquals($this->grade($question, '1.2346'), 0.9);

        $question = test_question_maker::make_question('varnumericset', '3_sig_figs_trailing_zero');
        $this->assertEquals($this->grade($question, '0.0720'), 1);
        $this->assertEquals($this->grade($question, '00.0720'), 1);
        $this->assertEquals($this->grade($question, '00.07200'), 0.9);
        $this->assertEquals($this->grade($question, '+00.07200'), 0.9);
        $this->assertEquals($this->grade($question, '+0.0720'), 1);
        $this->assertEquals($this->grade($question, '+0.072'), 0);
        $this->assertEquals($this->grade($question, '0.072'), 0);

        $question = test_question_maker::make_question('varnumericset', '3_sig_figs_trailing_zero_negative_answer');
        $this->assertEquals($this->grade($question, '-0.0720'), 1);
        $this->assertEquals($this->grade($question, '-00.0720'), 1);
        $this->assertEquals($this->grade($question, '-00.07200'), 0.9);
        $this->assertEquals($this->grade($question, '-00.07200'), 0.9);
        $this->assertEquals($this->grade($question, '-0.072'), 0);

        $question = test_question_maker::make_question('varnumericset', '1_sig_fig');
        $this->assertEquals($this->grade($question, '1e9'), 1);
        $this->assertEquals($this->grade($question, '1x10<sup>9</sup>'), 1);
        $this->assertEquals($this->grade($question, '+1x10<sup>+9</sup>'), 1);
        $question->answers[1]->answer = '-1.0e9';
        $this->assertEquals($this->grade($question, '-1e9'), 1);
        $this->assertEquals($this->grade($question, '-1x10<sup>9</sup>'), 1);
        $this->assertEquals($this->grade($question, '-1x10<sup>+9</sup>'), 1);
    }

    public function test_get_question_summary() {
        $question = test_question_maker::make_question('varnumericset', 'with_variables');
        $question->start_attempt(new question_attempt_step(), 1);
        $this->assertEquals('What is 2 + 3?', $question->get_question_summary());
    }
}
